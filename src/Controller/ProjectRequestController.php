<?php

namespace App\Controller;

use App\Entity\ProjectRequest;
use App\Entity\Criterion;
use App\Entity\LdapUser;
use App\Form\ProjectRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\FileManager;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/solicitud")
 */
class ProjectRequestController extends AbstractController {

  /**
   * @Route("es/", name="project_request_index", methods={"GET"})
   */
  public function index(Security $security): Response {
    $loggedUser = $security->getUser();
    $role = $loggedUser->getRole()->getDescription();
    $data = [];

    switch ($role) {
      case "ROLE_ADMIN":
        $requestsFilter = array("state" => 28);
        $role = $this->getDoctrine()->getRepository(\App\Entity\UsersRoles::class)->find(4);

        $data['evaluators'] = $this->getDoctrine()->getRepository(LdapUser::class)->findBy(array("role" => $role));
        break;
      case "ROLE_STUDENT":
        $requestsFilter = array("owner" => $loggedUser, "state" => [27, 28]);
        break;
      case "ROLE_RESEARCHER":
        $requestsFilter = array("owner" => $loggedUser, "state" => [27, 28]);
        break;
      case "ROLE_EVALUATOR":
        $requestsFilter = array("owner" => $loggedUser, "state" => [28]);
        break;
      default:
        $requestsFilter = array("state" => 2);
        break;
    }

    $projectRequests = $this->getDoctrine()->getRepository(ProjectRequest::class)->findBy($requestsFilter);
    $data['project_requests'] = $projectRequests;

    return $this->render('project_request/index.html.twig', $data);
  }

  /**
   * @Route("/admin", name="project_request_index_admin", methods={"GET"})
   */
  public function indexAdmin(): Response {
    $projectRequests = $this->getDoctrine()
            ->getRepository(ProjectRequest::class)
            ->findAll();
    
    $entityManager = $this->getDoctrine()->getManager('sip');
    $entityManagerOracle = $this->getDoctrine()->getManager('oracle');
    $test = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getExternalCollaborationByProject($entityManager, 'B0802');
    echo "<pre>";
    var_dump($test);
    echo "</pre>";
    echo "<hr>";
    $estudiante = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getEstudianteByCarnet($entityManagerOracle, 'B04278');
    echo "<pre>";
    var_dump($estudiante);
    echo "</pre>";
    echo "<hr>";
    $invest_colaboradores = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getInvesColaboradoresByProject($entityManager, 'B0802');
    echo "<pre>";
    var_dump($invest_colaboradores);
    echo "</pre>";
    echo "<hr>";
    $proyecto_info = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getProjectById($entityManager, 'B0802');
    echo "<pre>";
    var_dump($proyecto_info);
    echo "</pre>";
    echo "<hr>";
    $proyecto_metodologia = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getMetodologiaByProject($entityManager, 'B4143');
    echo "<pre>";
    var_dump($proyecto_metodologia);
    echo "</pre>";
    die();

    return $this->render('project_request/index.html.twig', [
                'project_requests' => $projectRequests,
    ]);
  }

  private function getProjectExternalInformation($projectCode) {
    $entityManager = $this->getDoctrine()->getManager('sip');
    $externalCollaboration = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getExternalCollaborationByProject($entityManager, $projectCode);

    $projectData = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getSIPProjectByCode($entityManager, $projectCode);

    $unitData = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getAcademicUnitByProject($entityManager, $projectData["codigo_unidad"]);

    $researchers = $this->getDoctrine()
            ->getRepository(UsersRoles::class)
            ->getResearchersByProject($entityManager, $projectCode);

    return array(
        "externalCollaboration" => $externalCollaboration,
        "projectData" => $projectData,
        "unitData" => $unitData,
        "researchers" => $researchers
    );
  }

  /**
   * @Route("/new", name="project_request_new", methods={"GET","POST"})
   */
  public function new(Request $request, FileManager $fileManager, Security $security): Response {
    $loggedUser = $security->getUser();

    $projectRequest = new ProjectRequest();
    $form = $this->createForm(ProjectRequestType::class, $projectRequest);
    $form->handleRequest($request);

    $minuteCommissionTFGFiles = [];
    $extInstitutionsAuthorizationFiles = [];
    $minuteFinalWorkFiles = [];
    $minutesResearchCenterFiles = [];

    if ($form->isSubmitted() && $form->isValid()) {
      $projectDir = $this->getParameter('brochures_directory');

      if ($loggedUser->getRole()->getDescription() === "ROLE_STUDENT") {
        $minuteFinalWorkUploadedFiles = $form->get("minuteFinalWorkFiles")->getData();
        $minutesResearchCenterUploadedFiles = $form->get("minutesResearchCenterFiles")->getData();

        $minuteFinalWorkFiles = $fileManager->uploadFiles($minuteFinalWorkUploadedFiles, $projectDir, "minuteFinalWorkFiles");
        $minutesResearchCenterFiles = $fileManager->uploadFiles($minutesResearchCenterUploadedFiles, $projectDir, "minutesResearchCenterFiles");
      } else {
        $minuteCommissionTFGUploadedFiles = $form->get("minuteCommissionTFGFiles")->getData();
        $minuteCommissionTFGFiles = $fileManager->uploadFiles($minuteCommissionTFGUploadedFiles, $projectDir, "minuteCommissionTFGFiles");
      }

      $extInstitutionsAuthorizationUploadedFiles = $form->get("extInstitutionsAuthorizationFiles")->getData();
      $extInstitutionsAuthorizationFiles = $fileManager->uploadFiles($extInstitutionsAuthorizationUploadedFiles, $projectDir, "extInstitutionsAuthorizationFiles");


      $projectRequest->addInfoRequestFiles(array_merge($minuteCommissionTFGFiles ?? [], $extInstitutionsAuthorizationFiles ?? [], $minuteFinalWorkFiles ?? [], $minutesResearchCenterFiles ?? []));

      $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      $projectRequest->setState($state);
      $entityManager = $this->getDoctrine()->getManager();

      $entityManager->persist($projectRequest);
      $entityManager->flush();

      $target = $form->get("form_target_input")->getData();

      $route = $this->getTargetRoute($target);
      $data = ['id' => $projectRequest->getId()];
      $projectRequest->setCode("CEC-" + $projectRequest->getId());
      $projectRequest->setOwner($loggedUser);
      $entityManager->flush();

      return $this->redirectToRoute($route, $data);
    }

    return $this->render('project_request/new.html.twig', [
                'project_request' => $projectRequest,
                'form' => $form->createView()
    ]);
  }

  private function getTargetRoute($target) {
    switch ($target) {
      case "info":
        $route = 'tab_general_info_request_edit';
        break;
      case "academic":
        $route = 'tab_academic_request_info';
        break;
      case "ethic":
        $route = 'tab_ethic_eval_request';
        break;
      default:
        $route = 'tab_academic_request_info';
        break;
    }
    return $route;
  }

  /**
   * @Route("/detalle/{id}", name="project_request_show", methods={"GET"})
   */
  public function show(ProjectRequest $projectRequest): Response {
    return $this->render('project_request/show.html.twig', [
                'project_request' => $projectRequest,
    ]);
  }

  /**
   * @Route("/edit/{id}", name="project_request_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, ProjectRequest $projectRequest, FileManager $fileManager, Security $security): Response {
    $loggedUser = $security->getUser();

    $form = $this->createForm(ProjectRequestType::class, $projectRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $projectDir = $this->getParameter('brochures_directory');

      if ($loggedUser->getRole()->getDescription() === "ROLE_STUDENT") {
        $minuteFinalWorkUploadedFiles = $form->get("minuteFinalWorkFiles")->getData();
        $minutesResearchCenterUploadedFiles = $form->get("minutesResearchCenterFiles")->getData();

        $minuteFinalWorkFiles = $fileManager->uploadFiles($minuteFinalWorkUploadedFiles, $projectDir, "minuteFinalWorkFiles");
        $minutesResearchCenterFiles = $fileManager->uploadFiles($minutesResearchCenterUploadedFiles, $projectDir, "minutesResearchCenterFiles");
      } else {
        $minuteCommissionTFGUploadedFiles = $form->get("minuteCommissionTFGFiles")->getData();
        $minuteCommissionTFGFiles = $fileManager->uploadFiles($minuteCommissionTFGUploadedFiles, $projectDir, "minuteCommissionTFGFiles");
      }

      $extInstitutionsAuthorizationUploadedFiles = $form->get("extInstitutionsAuthorizationFiles")->getData();
      $extInstitutionsAuthorizationFiles = $fileManager->uploadFiles($extInstitutionsAuthorizationUploadedFiles, $projectDir, "extInstitutionsAuthorizationFiles");


      $projectRequest->addInfoRequestFiles(array_merge($minuteCommissionTFGFiles ?? [], $extInstitutionsAuthorizationFiles ?? [], $minuteFinalWorkFiles ?? [], $minutesResearchCenterFiles ?? []));
      $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      $projectRequest->setState($state);
      $target = $form->get("form_target_input")->getData();

      $this->getDoctrine()->getManager()->flush();

      $route = $this->getTargetRoute($target);
      $data = ['id' => $projectRequest->getId()];

      return $this->redirectToRoute($route, $data);
    }

    return $this->render('project_request/edit.html.twig', [
                'project_request' => $projectRequest,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="project_request_delete", methods={"DELETE"})
   */
  public function delete(Request $request, ProjectRequest $projectRequest): Response {
    if ($this->isCsrfTokenValid('delete' . $projectRequest->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($projectRequest);
      $entityManager->flush();
    }

    return $this->redirectToRoute('project_request_index');
  }

}

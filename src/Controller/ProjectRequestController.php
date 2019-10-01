<?php

namespace App\Controller;

use App\Entity\ProjectRequest;
use App\Entity\Criterion;
use App\Entity\LdapUser;
use App\Entity\TeamWork;
use App\Form\ProjectRequestType;
use App\Entity\PreEvalRequest;
use App\Form\PreEvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\FileManager;
use App\Services\Utils\ExternalDataManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\UsersRoles;

use App\Entity\AcademicRequestInfo;
use App\Entity\EthicEvalRequest;

use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
/**
 * @Route("/solicitud")
 */
class ProjectRequestController extends AbstractController {

  /**
   * @Route("es/", name="project_request_index", methods={"GET"})
   */
  public function index(Security $security): Response {
    $loggedUser = $security->getUser();
    $projectRequests = null;
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
        
        $projectRequests = $this->getDoctrine()->getRepository(ProjectRequest::class)->getProjectByEvaluator($loggedUser, 28);
        break;
      default:
        $requestsFilter = array("state" => 2);
        break;
    }
    if (isset($requestsFilter)){
      $projectRequests = $projectRequests ? $projectRequests : $this->getDoctrine()->getRepository(ProjectRequest::class)->findBy($requestsFilter);
    }
    
    $data['project_requests'] = $projectRequests;
    
    foreach ($projectRequests as $projectRequest) {
      $data['project_requests_users'][$projectRequest->getId()] = array();
      foreach ($projectRequest->getUsers() as $user) {
        $data['project_requests_users'][$projectRequest->getId()][] = $user->getId();
      }
    }
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

  /**
   * @Route("/get_external_data_by_project_code", name="get_external_data_by_project_code", methods={"POST"})
   */
  public function getProjectExternalInformation(ExternalDataManager $externalDataManager, Request $request): Response {
    $projectCode = $request->request->get('projectCode');
    return new JsonResponse($this->getInformationByProject($externalDataManager, $projectCode));
  }

  private function getInformationByProject($externalDataManager, $projectCode) {

    $entityManager = $this->getDoctrine()->getManager('sip');
    $emOracle = $this->getDoctrine()->getManager('oracle');
    
    $projectData = $externalDataManager->getProjectInfoByCode($emOracle, $projectCode);
    if ($projectData) {
      $externalCollaboration = $externalDataManager->getExternalCollaborationByProject($entityManager, $projectCode);
      $researchers = $externalDataManager->getResearchersByProject($emOracle, $projectCode);
      return ["externalCollaboration" => $externalCollaboration,
          "projectData" => $projectData,
          "researchers" => $researchers, 
          "projectWasFound" => true];
    }
    return ["projectWasFound" => false, "externalCollaboration" => null,
          "projectData" => null,
          "researchers" => null];
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
        $projectCode = $request->request->get('project_code');
        $projectRequest->setSipProject($projectCode);
        $minuteCommissionTFGUploadedFiles = $form->get("minuteCommissionTFGFiles")->getData();
        $minuteCommissionTFGFiles = $fileManager->uploadFiles($minuteCommissionTFGUploadedFiles, $projectDir, "minuteCommissionTFGFiles");
      }

      $extInstitutionsAuthorizationUploadedFiles = $form->get("extInstitutionsAuthorizationFiles")->getData();
      $extInstitutionsAuthorizationFiles = $fileManager->uploadFiles($extInstitutionsAuthorizationUploadedFiles, $projectDir, "extInstitutionsAuthorizationFiles");


      $projectRequest->addInfoRequestFiles(array_merge($minuteCommissionTFGFiles ?? [], $extInstitutionsAuthorizationFiles ?? [], $minuteFinalWorkFiles ?? [], $minutesResearchCenterFiles ?? []));

      $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      // $projectRequest->setTitle($state);
      $projectRequest->setState($state);
      $projectRequest->setDate(new \DateTime('now'));
      $entityManager = $this->getDoctrine()->getManager();

      $entityManager->persist($projectRequest);
      $entityManager->flush();

      $target = $form->get("form_target_input")->getData();

      $route = $this->getTargetRoute($target);
      $data = ['id' => $projectRequest->getId()];
      $projectRequest->setCode($projectRequest->getId());
      $projectRequest->setOwner($loggedUser);
      $entityManager->flush();

      return $this->redirectToRoute($route, $data);
    }

    return $this->render('project_request/new.html.twig', [
                'project_request' => $projectRequest,
                'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/remove_student_by_id", name="remove_student_by_id", methods={"POST"})
   */
  public function removeStudentAjax(Request $request): Response {
    $student_id = $request->request->get('id');
    if ($student_id) {
      $entityManager = $this->getDoctrine()->getManager();
      $file = $this->getDoctrine()->getRepository(TeamWork::class)->find($student_id);

      $entityManager->remove($file);
      $entityManager->flush();

      return new JsonResponse(['wasDeleted' => true]);
    }

    return new JsonResponse(['wasDeleted' => false]);
  }

  /**
   * @Route("/get_student_by_id", name="get_student_by_id", methods={"POST"})
   */
  public function getStudentById(Request $request, ExternalDataManager $externalDataManager): Response {
    $studentId = $request->request->get('id');

    $em = $this->getDoctrine()->getManager('oracle');
    $student = $externalDataManager->getStudentById($em, $studentId); //'B04278'

    if ($student) {
      return new JsonResponse(["student" => $student[0], "studentWasFound" => true]);
    }
    return new JsonResponse(["studentWasFound" => false]);
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
   * @Route("/{id}/detalle", name="project_request_show", methods={"GET"})
   */
  public function show(ProjectRequest $projectRequest, Request $request, ExternalDataManager $externalDataManager): Response {
    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest->getId());
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectRequest->getId());

    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;

    if( $projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER" ){
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }

    return $this->render('project_request/show.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
    ]);
  }
  
    /**
   * @Route("/{id}/evaluar", name="project_request_show", methods={"GET"})
   */
  public function evaluate(ProjectRequest $projectRequest, Request $request, ExternalDataManager $externalDataManager): Response {
    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest->getId());
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectRequest->getId());

    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;
    
    $preEvalRequest = new PreEvalRequest();
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if( $projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER" ){
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }

    return $this->render('pre_eval_request/new.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
                'form' => $form->createView(),
    ]);
  }
        
  /**
   * @Route("/{id}", name="project_details_show_by_id", methods={"GET"})
   */
  public function showDetailsById(ProjectRequest $projectRequest, Request $request, ExternalDataManager $externalDataManager): Response {
    $projectId = $projectRequest->getId();

    // var_dump($projectId);
    // die();

    $projectRequest = $this->getDoctrine()->getRepository(ProjectRequest::class)->find($projectId);
    //$projectRequest->getInfoRequestFiles();

    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    // $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->find($projectId);
    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectId);

    // $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->find($projectId);
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectId);

    // var_dump($projectRequest->getOwner()->getRole()->getDescription());
    // die();
    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;

    if( $projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER" ){
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }

    return $this->render('project_request/details.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
    ]);
  }

  /**
   * @Route("/edit/{id}", name="project_request_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, ProjectRequest $projectRequest, FileManager $fileManager, Security $security, ExternalDataManager $externalDataManager): Response {
    $loggedUser = $security->getUser();

    $form = $this->createForm(ProjectRequestType::class, $projectRequest);
    $form->handleRequest($request);

    $projectInfo = null;

    if ($form->isSubmitted() && $form->isValid()) {

      $projectDir = $this->getParameter('brochures_directory');

      if ($loggedUser->getRole()->getDescription() === "ROLE_STUDENT") {
        $minuteFinalWorkUploadedFiles = $form->get("minuteFinalWorkFiles")->getData();
        $minutesResearchCenterUploadedFiles = $form->get("minutesResearchCenterFiles")->getData();

        $minuteFinalWorkFiles = $fileManager->uploadFiles($minuteFinalWorkUploadedFiles, $projectDir, "minuteFinalWorkFiles");
        $minutesResearchCenterFiles = $fileManager->uploadFiles($minutesResearchCenterUploadedFiles, $projectDir, "minutesResearchCenterFiles");

        $uploadedTeamWork = $request->request->get('teamWork');
        $teamWork = $this->arrangeUploadedStudents($uploadedTeamWork);
        $projectRequest->addTeamWork($teamWork);
      } else {
        $projectCode = $request->request->get('project_code');
        $projectRequest->setSipProject($projectCode);
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
    } else {
      if ($loggedUser->getRole()->getDescription() === "ROLE_RESEARCHER") {
        $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      }
    }
    
    return $this->render('project_request/edit.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'form' => $form->createView(),
    ]);
  }

  private function arrangeUploadedStudents($uploadedTeamWork) {
    $teamWork = array();
    if (isset($uploadedTeamWork["student_name"]) && count($uploadedTeamWork["student_name"]) > 0) {
      for ($i = 0; $i < count($uploadedTeamWork["student_name"]); $i++) {
        $student = new \App\Entity\TeamWork();
        $student->setName($uploadedTeamWork["student_name"][$i]);
        $student->setStudentId($uploadedTeamWork["student_id"][$i]);
        $student->setStudentEmail($uploadedTeamWork["student_email"][$i]);

        $this->getDoctrine()->getManager()->persist($student);

        array_push($teamWork, $student);
      }
      return $teamWork;
      
    }
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
  private function getExtraInformationByProject($externalDataManager, $projectCode) {

    $entityManager = $this->getDoctrine()->getManager('sip');
    $emOracle = $this->getDoctrine()->getManager('oracle');

    $projectData = $externalDataManager->getInfoByProject($emOracle, $projectCode);
    if ($projectData) {
      return $projectData;
    }
    return false;
  }
  /**
    * @Route("/generate-pdf/{id}", name="generate_pdf", methods={"GET","POST"})
    */
    public function downloadSpecifications(Request $request,ExternalDataManager $externalDataManager,Pdf $pdf): Response {

    

      $projectId = $request->get('id');

    // var_dump($projectId);
    // die();

    $projectRequest = $this->getDoctrine()->getRepository(ProjectRequest::class)->find($projectId);
    //$projectRequest->getInfoRequestFiles();

    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    // $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->find($projectId);
    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectId);

    // $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->find($projectId);
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectId);

    // var_dump($projectRequest->getOwner()->getRole()->getDescription());
    // die();
    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;

    if( $projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER" ){
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }


      $html = $this->renderView('project_request/details.html.twig', [
        'project_request' => $projectRequest,
        'project_info' => $projectInfo,
        'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
        'academicRequestInfo' => $academicRequestInfo,
        'ethicEvalRequest' => $ethicEvalRequest,
        'SipProjectExtraInformation' => $SipProjectExtraInformation,
        'SipProject' => $SipProject,
        'objetivoPrincipal' => $objetivoPrincipal,
      ]);
      
      $fecha = $projectRequest->getDate();
      $f = date_format($fecha,"Y");
      $fYear = substr($f,-2);
    
      $filename = "Proyecto-CEC-".$projectRequest->getId()."-".$fYear.".pdf";
      return new PdfResponse(
          $pdf->getOutputFromHtml($html),
          $filename 
      );
  }

  /**
    * @Route("/generate", name="app_generate_pdf", methods={"GET","POST"})
    */
  public function downloadSpecificationsTest(ExternalDataManager $externalDataManager,Pdf $pdf): Response {


    $projectId = 53;
    // var_dump($projectId);
    // die();
    $projectRequest = $this->getDoctrine()->getRepository(ProjectRequest::class)->find(53);
    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();
    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectId);
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectId);
    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;

    if( $projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER" ){
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }


      $html = $this->renderView('project_request/details.html.twig', [
        'project_request' => $projectRequest,
        'project_info' => $projectInfo,
        'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
        'academicRequestInfo' => $academicRequestInfo,
        'ethicEvalRequest' => $ethicEvalRequest,
        'SipProjectExtraInformation' => $SipProjectExtraInformation,
        'SipProject' => $SipProject,
        'objetivoPrincipal' => $objetivoPrincipal,
      ]);


    
    return new PdfResponse($pdf->getOutputFromHtml($html), 'invoice.pdf');

  }

}

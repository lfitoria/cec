<?php

namespace App\Controller;

use App\Entity\ProjectRequest;
use App\Entity\Criterion;
use App\Entity\LdapUser;
use App\Entity\TeamWork;
use App\Form\ProjectRequestType;
use App\Entity\PreEvalRequest;
use App\Form\PreEvalRequestType;
use App\Entity\EvalRequest;
use App\Form\EvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\FileManager;
// use App\Services\Utils\Pdf;
use App\Services\Utils\ExternalDataManager;
use App\Services\Utils\LogManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\UsersRoles;
use App\Entity\AcademicRequestInfo;
use App\Entity\EthicEvalRequest;
use App\Entity\WorkLog;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\NativeHttpClient;

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
        $requestsFilter = array();
        $role = $this->getDoctrine()->getRepository(\App\Entity\UsersRoles::class)->find(4);
        
        $data['evaluators'] = $this->getDoctrine()->getRepository(LdapUser::class)->findBy(array("role" => $role));
        break;
      case "ROLE_STUDENT":
        $requestsFilter = array("owner" => $loggedUser, "state" => [27, 28, 35, 36,31,42]);
        break;
      case "ROLE_RESEARCHER":
        $requestsFilter = array("owner" => $loggedUser, "state" => [27, 28, 35, 36,31,42]);
        break;
      case "ROLE_EVALUATOR":

        // $projectRequests = $this->getDoctrine()->getRepository(ProjectRequest::class)->getProjectByEvaluator($loggedUser, 28);
        $projectRequests = $this->getDoctrine()->getRepository(ProjectRequest::class)->getProjectByEvaluator($loggedUser, array(27, 28, 35, 36,31,42));
        break;
      default:
        $requestsFilter = array("state" => 2);
        break;
    }
    if (isset($requestsFilter)) {
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
    return [
              "projectWasFound" => false, 
              "externalCollaboration" => false,
              "projectData" => false,
              "researchers" => false
          ];
  }

  /**
   * @Route("/new", name="project_request_new", methods={"GET","POST"})
   */
  public function new(Request $request, FileManager $fileManager, Security $security, ExternalDataManager $externalDataManager): Response {
    $data = $request->request->all();
    $loggedUser = $security->getUser();

    $projectRequest = new ProjectRequest();
    $form = $this->createForm(ProjectRequestType::class, $projectRequest);
    $form->handleRequest($request);

    $minuteCommissionTFGFiles = [];
    $extInstitutionsAuthorizationFiles = [];
    $minuteFinalWorkFiles = [];
    $minutesResearchCenterFiles = [];
    $categoryBiomedicaFiles = [];
    $applicationLetterFiles = [];

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
      $applicationLetterUploadedFiles = $form->get("applicationLetterFiles")->getData();
      $applicationLetterFiles = $fileManager->uploadFiles($applicationLetterUploadedFiles, $projectDir, "applicationLetterFiles");

      $categoryBiomedicaFilesCenterUploadedFiles = $form->get("categoryBiomedicaFiles")->getData();
      $categoryBiomedicaFiles = $fileManager->uploadFiles($categoryBiomedicaFilesCenterUploadedFiles, $projectDir, "categoryBiomedicaFiles");

      $extInstitutionsAuthorizationUploadedFiles = $form->get("extInstitutionsAuthorizationFiles")->getData();
      $extInstitutionsAuthorizationFiles = $fileManager->uploadFiles($extInstitutionsAuthorizationUploadedFiles, $projectDir, "extInstitutionsAuthorizationFiles");


      $projectRequest->addInfoRequestFiles(array_merge($minuteCommissionTFGFiles ?? [], $extInstitutionsAuthorizationFiles ?? [], $minuteFinalWorkFiles ?? [], $minutesResearchCenterFiles ?? [], $categoryBiomedicaFiles ?? [], $applicationLetterFiles ?? []));

      $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      // $projectRequest->setTitle($state);
      $projectRequest->setState($state);
      $projectRequest->setDate(new \DateTime('now'));

      $projectRequest->setUacademica($data["project_request"]["uacademica"]);
      
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

    // $entityManager = $this->getDoctrine()->getManager('sip');
    // // $allUnitsSIP = $externalDataManager->getAllUnitsSIP($entityManager);
    // $allUnitsSIP = false;

    return $this->render('project_request/new.html.twig', [
                'project_request' => $projectRequest,
                'form' => $form->createView(),
                
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
    // echo "<pre>";
    // var_dump($student);
    // echo "</pre>";
    // die();

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

    $requestLogs = $this->getDoctrine()
            ->getRepository(WorkLog::class)
            ->findBy(array("request" => $projectRequest));

    if ($projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }
    $pre_eval_info = $this->getDoctrine()->getRepository(PreEvalRequest::class)->getAllPreEvalInfo($projectRequest->getId());
    $eval_info = $this->getDoctrine()->getRepository(EvalRequest::class)->getAllEvalInfo($projectRequest->getId());

    return $this->render('project_request/show.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
                'requestLogs' => $requestLogs,
                'pre_eval_info' => $pre_eval_info,
                'eval_info' => $eval_info
    ]);
  }

  /**
   * @Route("/{id}/evaluar", name="project_request_pre_evaluate", methods={"GET"})
   */
  public function evaluate(ProjectRequest $projectRequest, Request $request, ExternalDataManager $externalDataManager): Response {
    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest->getId());

    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectRequest->getId());

    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;


    $preEvalRequestSaved = $this->getDoctrine()
            ->getRepository(PreEvalRequest::class)
            ->findOneBy(array("request" => $projectRequest, "current" => 0));
    
    $requestLogs = $this->getDoctrine()
            ->getRepository(WorkLog::class)
            ->findBy(array("request" => $projectRequest));

    $preEvalRequest = $preEvalRequestSaved ? $preEvalRequestSaved : new PreEvalRequest();
    $preEvalRequestAction = $preEvalRequestSaved ? $this->generateUrl('pre_eval_request_edit', array('id' => $preEvalRequestSaved->getId(), 'id_request' => $projectRequest->getId())) : $this->generateUrl('pre_eval_request_new', array('id' => $projectRequest->getId()));

    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest, [
        'action' => $preEvalRequestAction,
    ]);
    $form->handleRequest($request);
    if ($projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
      
    }

    $pre_eval_info = $this->getDoctrine()->getRepository(PreEvalRequest::class)->getAllPreEvalInfo($projectRequest->getId());
    
    // var_dump($pre_eval_info);
    // die();

    return $this->render('pre_eval_request/new.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
                'requestLogs' => $requestLogs,
                'form' => $form->createView(),
                'pre_eval_info' => false,
                'pre_eval' => $pre_eval_info,
                'eval_info' => false,
    ]);
  }
  /**
   * @Route("/{id}/determinar", name="project_request_evaluate", methods={"GET"})
   */
  public function determinate(ProjectRequest $projectRequest, Request $request, ExternalDataManager $externalDataManager): Response {
    $projectId_getMinuteCommissionTFG = $projectRequest->getInfoRequestFiles();

    $academicRequestInfo = $this->getDoctrine()->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest->getId());
    $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectRequest->getId());

    $projectInfo = null;
    $SipProjectExtraInformation = null;
    $SipProject = null;
    $objetivoPrincipal = null;


    $EvalRequestSaved = $this->getDoctrine()
            ->getRepository(EvalRequest::class)
            ->findOneBy(array("request" => $projectRequest, "current" => 0));
    
    $requestLogs = $this->getDoctrine()
            ->getRepository(WorkLog::class)
            ->findBy(array("request" => $projectRequest));

    $EvalRequest = $EvalRequestSaved ? $EvalRequestSaved : new EvalRequest();
    $EvalRequestAction = $EvalRequestSaved ? $this->generateUrl('eval_request_edit', array('id' => $EvalRequestSaved->getId(), 'id_request' => $projectRequest->getId())) : $this->generateUrl('eval_request_new', array('id' => $projectRequest->getId()));

    $form = $this->createForm(EvalRequestType::class, $EvalRequest, [
        'action' => $EvalRequestAction,
    ]);
    $form->handleRequest($request);
    if ($projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }
    $eval_info = $this->getDoctrine()->getRepository(EvalRequest::class)->getAllEvalInfo($projectRequest->getId());

    return $this->render('eval_request/new.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'projectId_getMinuteCommissionTFG' => $projectId_getMinuteCommissionTFG,
                'academicRequestInfo' => $academicRequestInfo,
                'ethicEvalRequest' => $ethicEvalRequest,
                'SipProjectExtraInformation' => $SipProjectExtraInformation,
                'SipProject' => $SipProject,
                'objetivoPrincipal' => $objetivoPrincipal,
                'requestLogs' => $requestLogs,
                'form' => $form->createView(),
                'eval_info' => false,
                'eval' => $eval_info,
                'pre_eval_info' => false
    ]);
  }

  /**
   * @Route("/asasa/{id}", name="project_details_show_by_id", methods={"GET"})
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

    if ($projectRequest->getOwner()->getRole()->getDescription() == "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $SipProject = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
      $emOracle = $this->getDoctrine()->getManager('oracle');
      $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectRequest->getSipProject());
    }

    // var_dump($SipProject);
    // die();

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
        // var_dump($form->get("minuteFinalWorkFiles")->getData());
        $minuteFinalWorkUploadedFiles = $form->get("minuteFinalWorkFiles")->getData();
        $minutesResearchCenterUploadedFiles = $form->get("minutesResearchCenterFiles")->getData();

        $minuteFinalWorkFiles = $fileManager->uploadFiles($minuteFinalWorkUploadedFiles, $projectDir, "minuteFinalWorkFiles");
        // var_dump($projectDir);
        // die();
        $minutesResearchCenterFiles = $fileManager->uploadFiles($minutesResearchCenterUploadedFiles, $projectDir, "minutesResearchCenterFiles");

        $uploadedTeamWork = $request->request->get('teamWork');
        $teamWork = $this->arrangeUploadedStudents($uploadedTeamWork);
        $projectRequest->addTeamWork($teamWork);

        // var_dump($minuteFinalWorkUploadedFiles);
        // var_dump($minuteFinalWorkFiles);

      } else {
        $projectCode = $request->request->get('project_code');
        $projectRequest->setSipProject($projectCode);
        $minuteCommissionTFGUploadedFiles = $form->get("minuteCommissionTFGFiles")->getData();
        $minuteCommissionTFGFiles = $fileManager->uploadFiles($minuteCommissionTFGUploadedFiles, $projectDir, "minuteCommissionTFGFiles");

        // var_dump("researcher");
        // var_dump($minuteCommissionTFGUploadedFiles);
        // var_dump($minuteCommissionTFGFiles);
      }
      $applicationLetterUploadedFiles = $form->get("applicationLetterFiles")->getData();
      $applicationLetterFiles = $fileManager->uploadFiles($applicationLetterUploadedFiles, $projectDir, "applicationLetterFiles");

      $categoryBiomedicaFilesCenterUploadedFiles = $form->get("categoryBiomedicaFiles")->getData();
      $categoryBiomedicaFiles = $fileManager->uploadFiles($categoryBiomedicaFilesCenterUploadedFiles, $projectDir, "categoryBiomedicaFiles");

      $extInstitutionsAuthorizationUploadedFiles = $form->get("extInstitutionsAuthorizationFiles")->getData();
      $extInstitutionsAuthorizationFiles = $fileManager->uploadFiles($extInstitutionsAuthorizationUploadedFiles, $projectDir, "extInstitutionsAuthorizationFiles");

      
      
      // die();

      $projectRequest->addInfoRequestFiles(array_merge($minuteCommissionTFGFiles ?? [], $extInstitutionsAuthorizationFiles ?? [], $minuteFinalWorkFiles ?? [], $minutesResearchCenterFiles ?? [], $categoryBiomedicaFiles ?? [],$applicationLetterFiles ?? []));

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
   * @Route("/rest-api", name="rest_api", methods={"GET","POST"})
   */
  public function restApi(): Response {

  //   $client = new CurlHttpClient();
  //   $response = $client->request('POST', 'https://sla_serviciosexternos.sdp.ucr.ac.cr/Ws_Certificaciones.svc/rest/Ws_Certificaciones', [
  //     'query' => [
  //       'pvc_Usuario' => 'SysUsrVicerrectoriaInvestigacion',
  //       'pvc_Clave' => 'FN5uMcTVBDqv0',
  //       'pvn_NumeroEmpleado' => '0113060256',
  //   ],
  // ]);
  // $content = $response->getContent();
  //API Url
// $url = 'https://sla_serviciosexternos.sdp.ucr.ac.cr/Ws_Certificaciones.svc/rest/Ws_Certificaciones';
//  $url = 'https://pokeapi.co/api/v2/pokemon/ditto/';
//Initiate cURL.
// $ch = curl_init($url);
 
//The JSON data.
// $jsonData = array(
//         'pvc_Usuario' => 'SysUsrVicerrectoriaInvestigacion',
//         'pvc_Clave' => 'FN5uMcTVBDqv0',
//         'pvn_NumeroEmpleado' => '0113060256',
// );
 
//Encode the array into JSON.
// $jsonDataEncoded = json_encode($jsonData);
 
//Tell cURL that we want to send a POST request.
// curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
// $result = curl_exec($ch);
//poke
/*
$base = 'https://pokeapi.co/api/v2/pokemon/1';
$id = 1;
$data = file_get_contents($base);
$result = json_decode($data);
echo "<pre>";
  var_dump($result);
  echo "</pre>";
  echo "<hr>";
    echo "test";
    die();
*/
//JOSE
/*
$data = array(
  'pvc_Usuario' => 'SysUsrVicerrectoriaInvestigacion',
  'pvc_Clave' => 'FN5uMcTVBDqv0',
  'pvn_IdTipoIdentificacion' => 205770949,
  
);

$payload = json_encode($data);

// Prepare new cURL resource
// $ch = curl_init('https://sla_serviciosexternos.ads.ci.ucr.ac.cr/Ws_DatosPersonales.svc');
$ch = curl_init('https://sla_serviciosexternos.sdp.ucr.ac.cr/Ws_DatosPersonales.svc/rest/ObtenerNumeroDeEmpleado');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// Set HTTP Header for POST request 
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Content-Length: ' . strlen($payload))
);

// Submit the POST request
$result = curl_exec($ch);

// Close cURL session handle
curl_close($ch);
var_dump($result);
  echo "</pre>";
  echo "<hr>";
  echo "test";
  die();

    return false;
  }*/
  return $this->render('project_request/rest-api.html.twig');
  }
}

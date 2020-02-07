<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\AcademicRequestInfo;
use App\Entity\ProjectRequest;
use App\Entity\EthicEvalRequest;
use App\Form\ProjectRequestType;
use App\Form\AcademicRequestInfoType;
use App\Form\EthicEvalRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\Utils\ExternalDataManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/solicitud")
 */
class RequestFormController extends AbstractController {

  protected $repository;
  protected $em;
  protected $container;
  protected $security;

  function __construct(EntityManagerInterface $em, ContainerInterface $container, Security $security) {
    $this->em = $em;
    $this->container = $container;
    $this->security = $security;
  }

  /**
   * @Route("/informacion", name="tab_general_info_request_new")
   */
  public function tabOneRequest(Request $request, ExternalDataManager $externalDataManager) {
    $loggedUser = $this->security->getUser();
    $projectRequest = new ProjectRequest();

    $form = $this->createForm(ProjectRequestType::class, $projectRequest, [
        'action' => $this->generateUrl('project_request_new'),
    ]);
    $form->handleRequest($request);

    $allUnitsSIP = null;
    if ($loggedUser->getRole()->getDescription() === "ROLE_RESEARCHER") {
      $entityManager = $this->getDoctrine()->getManager('sip');
      $allUnitsSIP = $externalDataManager->getAllUnitsSIP($entityManager);
    }


    // $allUnitsSIP = false;

    return $this->render('project_request/new.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => null,
                'form' => $form->createView(),
                'allUnitsSIP' => $allUnitsSIP
    ]);
  }

  /**
   * @Route("/informacion/{id}", name="tab_general_info_request_edit")
   */
  public function tabOneRequestEdit(Request $request, ProjectRequest $projectRequest, ExternalDataManager $externalDataManager, Security $security) {
    $loggedUser = $security->getUser();

    $form = $this->createForm(ProjectRequestType::class, $projectRequest, [
        'action' => $this->generateUrl('project_request_edit', ['id' => $projectRequest->getId()]),
    ]);
    $form->handleRequest($request);
    $projectInfo = null;
    if ($loggedUser->getRole()->getDescription() === "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());
    }

    return $this->render('project_request/edit.html.twig', [
                'project_request' => $projectRequest,
                'project_info' => $projectInfo,
                'form' => $form->createView()
    ]);
  }

  /**
   * @Route("/informacion-academica/{id}", name="tab_academic_request_info")
   */
  public function tabTwoRequest(Request $request, ProjectRequest $projectRequest, ExternalDataManager $externalDataManager, Security $security) {
    $loggedUser = $security->getUser();
    $formRoute = 'academic_request_info_new';
    $formData = ['id' => $projectRequest->getId()];
    $templateRoute = 'academic_request_info/new.html.twig';
    $academicRequestInfo = $this->em->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest);

    if ($academicRequestInfo) {
      $formRoute = 'academic_request_info_edit';
      $formData = ['id' => $academicRequestInfo->getId()];
      $templateRoute = 'academic_request_info/edit.html.twig';
    } else {
      $academicRequestInfo = new AcademicRequestInfo();
    }

    $form = $this->createForm(AcademicRequestInfoType::class, $academicRequestInfo, [
        'action' => $this->generateUrl($formRoute, $formData),
    ]);
    $form->handleRequest($request);

    $projectCode = $projectRequest->getSipProject();

    if ($loggedUser->getRole()->getDescription() === "ROLE_RESEARCHER") {
      $projectInfo = $this->getInformationByProject($externalDataManager, $projectRequest->getSipProject());


      $SipProject = $this->getInformationByProject($externalDataManager, $projectCode);

      $SipProjectExtraInformation = $this->getExtraInformationByProject($externalDataManager, $projectCode);

      $entityManager = $this->getDoctrine()->getManager('sip');
      $emOracle = $this->getDoctrine()->getManager('oracle');
      // getProjectInfoByCode
      // $objetivoPrincipal = $externalDataManager->getObjetivoPrincipalByProject($emOracle, $projectCode);
      $objetivoPrincipal = $externalDataManager->getProjectInfoByCode($emOracle, $projectCode);
      $objetivoGeneral = $externalDataManager->getProjectInfoByCode($emOracle, $projectCode);

      return $this->render($templateRoute, [
                  'academic_request_info' => $academicRequestInfo,
                  'form' => $form->createView(),
                  'SipProject' => $SipProject,
                  'SipProjectExtraInformation' => $SipProjectExtraInformation,
                  'objetivoPrincipal' => $objetivoPrincipal,
                  'objetivoGeneral' => $objetivoGeneral
      ]);
    }
    return $this->render($templateRoute, [
                'academic_request_info' => $academicRequestInfo,
                'form' => $form->createView(),
                    //'SipProject' => $SipProject,
                    // 'SipProjectExtraInformation' => $SipProjectExtraInformation,
                    // 'objetivoPrincipal' => $objetivoPrincipal,
    ]);
  }

  /**
   * @Route("/evaluacion-etica/{id}", name="tab_ethic_eval_request")
   */
  public function tabThreeRequest(Request $request, ProjectRequest $projectRequest) {

    $formRoute = 'ethic_eval_request_new';
    $formData = ['id' => $projectRequest->getId()];
    $templateRoute = 'ethic_eval_request/new.html.twig';
    $ethicEvalRequest = $this->em->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($projectRequest);

    if ($ethicEvalRequest) {
      $formRoute = 'ethic_eval_request_edit';
      $formData = ['id' => $ethicEvalRequest->getId()];
      $templateRoute = 'ethic_eval_request/edit.html.twig';
    } else {
      $ethicEvalRequest = new EthicEvalRequest();
    }
    $ldapUser = new LdapUser();
    $form_user = $this->createForm(LdapUserType::class, $ldapUser, [
      'action' => $this->generateUrl('ldap_user_new_modal')
    ]);

    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest, [
        'action' => $this->generateUrl($formRoute, $formData),
    ]);
    $form->handleRequest($request);

    return $this->render($templateRoute, [
                'ethic_eval_request' => $ethicEvalRequest,
                'form' => $form->createView(),
                'form_user' => $form_user->createView(),
    ]);
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

  private function getExtraInformationByProject($externalDataManager, $projectCode) {

    $entityManager = $this->getDoctrine()->getManager('sip');
    $emOracle = $this->getDoctrine()->getManager('oracle');

    $projectData = $externalDataManager->getInfoByProject($emOracle, $projectCode);
    if ($projectData) {
      return $projectData;
    }
    return false;
  }

}

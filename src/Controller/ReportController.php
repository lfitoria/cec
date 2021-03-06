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
use App\Services\Utils\PdfManager;
use App\Services\Utils\ExternalDataManager;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\UsersRoles;

use App\Entity\AcademicRequestInfo;
use App\Entity\EthicEvalRequest;
use App\Entity\EvalRequest;
use App\Entity\WorkLog;

// use Knp\Snappy\Pdf;
// use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
/**
 * @Route("/generar")
 */
class ReportController extends AbstractController {

    /**
    * @Route("/pdf/{id}", name="pdf", methods={"GET","POST"})
    */
    public function pdfProjectById(Request $request,ExternalDataManager $externalDataManager,PdfManager $pdf): Response {
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
    $pre_eval_info = $this->getDoctrine()->getRepository(PreEvalRequest::class)->getAllPreEvalInfo($projectRequest->getId());
    $eval_info = $this->getDoctrine()->getRepository(EvalRequest::class)->getAllEvalInfo($projectRequest->getId());

    $requestLogs = $this->getDoctrine()
            ->getRepository(WorkLog::class)
            ->findBy(array("request" => $projectRequest));

    $html = $this->renderView('project_request/details.html.twig', [
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
    
    $fecha = $projectRequest->getDate();
    $f = date_format($fecha,"Y");
    $fYear = substr($f,-2);
    
    //   $filename = "Proyecto-CEC-".$projectRequest->getId()."-".$fYear.".pdf";

    return $pdf->generatePdf($html,$projectId,$fYear);
    
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
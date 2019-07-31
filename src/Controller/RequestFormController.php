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

/**
 * @Route("/solicitud")
 */
class RequestFormController extends AbstractController {

    protected $repository;
    protected $em;
    protected $container;

    function __construct(EntityManagerInterface $em, ContainerInterface $container) {
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @Route("/informacion", name="tab_general_info_request_new")
     */
    public function tabOneRequest(Request $request) {
        $projectRequest = new ProjectRequest();

        $form = $this->createForm(ProjectRequestType::class, $projectRequest, [
            'action' => $this->generateUrl('project_request_new'),
        ]);
        $form->handleRequest($request);

        return $this->render('project_request/new.html.twig', [
                    'project_request' => $projectRequest,
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/informacion/{id}", name="tab_general_info_request_edit")
     */
    public function tabOneRequestEdit(Request $request, ProjectRequest $projectRequest) {

        $form = $this->createForm(ProjectRequestType::class, $projectRequest, [
            'action' => $this->generateUrl('project_request_edit', ['id' => $projectRequest->getId()]),
        ]);
        $form->handleRequest($request);

        return $this->render('project_request/edit.html.twig', [
                    'project_request' => $projectRequest,
                    'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/informacion-academica/{id}", name="tab_academic_request_info")
     */
    public function tabTwoRequest(Request $request, ProjectRequest $projectRequest) {
        $formRoute = 'academic_request_info_new';
        $formData = ['id' => $projectRequest->getId()];
        $templateRoute = 'academic_request_info/new.html.twig';
        $academicRequestInfo = $this->em->getRepository(AcademicRequestInfo::class)->getAcademicRequestInfoByRequest($projectRequest);
        
        if ($academicRequestInfo) {
            $formRoute = 'academic_request_info_edit';
            $formData = ['id' => $academicRequestInfo->getId()];
            $templateRoute = 'academic_request_info/edit.html.twig';
        }

        $form = $this->createForm(AcademicRequestInfoType::class, $academicRequestInfo, [
            'action' => $this->generateUrl($formRoute, $formData),
        ]);
        $form->handleRequest($request);

        return $this->render($templateRoute, [
                    'academic_request_info' => $academicRequestInfo,
                    'form' => $form->createView(),
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
        }
        
        $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest, [
            'action' => $this->generateUrl($formRoute, $formData),
        ]);
        $form->handleRequest($request);

        return $this->render($templateRoute, [
                    'ethic_eval_request' => $ethicEvalRequest,
                    'form' => $form->createView()
        ]);
    }
}

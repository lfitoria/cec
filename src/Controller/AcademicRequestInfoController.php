<?php

namespace App\Controller;

use App\Entity\AcademicRequestInfo;
use App\Entity\ProjectRequest;
use App\Entity\EthicEvalRequest;
use App\Form\AcademicRequestInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/academic/request/info")
 */
class AcademicRequestInfoController extends AbstractController
{
    /**
     * @Route("/", name="academic_request_info_index", methods={"GET"})
     */
    public function index(): Response
    {
        $academicRequestInfos = $this->getDoctrine()
            ->getRepository(AcademicRequestInfo::class)
            ->findAll();

        return $this->render('academic_request_info/index.html.twig', [
            'academic_request_infos' => $academicRequestInfos,
        ]);
    }

    /**
     * @Route("/new/{id}", name="academic_request_info_new", methods={"GET","POST"})
     */
    public function new(Request $request, ProjectRequest $projectRequest): Response
    {
        $academicRequestInfo = new AcademicRequestInfo();
        $form = $this->createForm(AcademicRequestInfoType::class, $academicRequestInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $academicRequestInfo->setRequest($projectRequest);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($academicRequestInfo);
            $entityManager->flush();

            $route = 'tab_ethic_eval_request';
            $data = ['id' => $academicRequestInfo->getRequest()->getId()];
            $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($academicRequestInfo->getRequest()->getId());
            if($ethicEvalRequest){
                $route = 'tab_ethic_eval_request';
                $data = ['id' => $ethicEvalRequest->getRequest()->getId()];
            }
            
            return $this->redirectToRoute($route, $data);
        }

        return $this->render('academic_request_info/new.html.twig', [
            'academic_request_info' => $academicRequestInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academic_request_info_show", methods={"GET"})
     */
    public function show(AcademicRequestInfo $academicRequestInfo): Response
    {
        return $this->render('academic_request_info/show.html.twig', [
            'academic_request_info' => $academicRequestInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="academic_request_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AcademicRequestInfo $academicRequestInfo): Response
    {
        $form = $this->createForm(AcademicRequestInfoType::class, $academicRequestInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $route = 'tab_ethic_eval_request';
            $data = ['id' => $academicRequestInfo->getRequest()->getId()];
            $ethicEvalRequest = $this->getDoctrine()->getRepository(EthicEvalRequest::class)->getEthicEvalRequestByRequest($academicRequestInfo->getRequest()->getId());
            
            if($ethicEvalRequest){
                $route = 'tab_ethic_eval_request';
                $data = ['id' => $ethicEvalRequest->getRequest()->getId()];
            }
            
            return $this->redirectToRoute($route, $data);
        }

        return $this->render('academic_request_info/edit.html.twig', [
            'academic_request_info' => $academicRequestInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="academic_request_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AcademicRequestInfo $academicRequestInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$academicRequestInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($academicRequestInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('academic_request_info_index');
    }
}

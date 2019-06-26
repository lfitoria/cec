<?php

namespace App\Controller;

use App\Services\Utils\FileUploader;
use App\Entity\EvalRequest;
use App\Form\EvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eval/request")
 */
class EvalRequestController extends AbstractController {

    /**
     * @Route("/", name="eval_request_index", methods={"GET"})
     */
    public function index(): Response {
        $evalRequests = $this->getDoctrine()
                ->getRepository(EvalRequest::class)
                ->findAll();

        return $this->render('eval_request/index.html.twig', [
                    'eval_requests' => $evalRequests,
        ]);
    }

    /**
     * @Route("/new", name="eval_request_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response {
        $evalRequest = new EvalRequest();
        $form = $this->createForm(EvalRequestType::class, $evalRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $tempFiles = $form->get("fakeFiles")->getData();
            
            $file = new \App\Entity\File();
            foreach ($tempFiles as $tempFile) {
                $projectDir = $this->getParameter('brochures_directory');
               
                $file = $fileUploader->upload($tempFile, $projectDir);
                $evalRequest->addFile($file);
                $em->persist($file);
            }
            
            $em->persist($evalRequest);
            $em->flush();

            return $this->redirectToRoute('eval_request_index');
        }

        return $this->render('eval_request/new.html.twig', [
                    'eval_request' => $evalRequest,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eval_request_show", methods={"GET"})
     */
    public function show(EvalRequest $evalRequest): Response {
        return $this->render('eval_request/show.html.twig', [
                    'eval_request' => $evalRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="eval_request_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EvalRequest $evalRequest): Response {
        $form = $this->createForm(EvalRequestType::class, $evalRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('eval_request_index', [
                        'id' => $evalRequest->getId(),
            ]);
        }

        return $this->render('eval_request/edit.html.twig', [
                    'eval_request' => $evalRequest,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="eval_request_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EvalRequest $evalRequest): Response {
        if ($this->isCsrfTokenValid('delete' . $evalRequest->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evalRequest);
            $em->flush();
        }

        return $this->redirectToRoute('eval_request_index');
    }

}

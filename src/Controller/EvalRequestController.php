<?php

namespace App\Controller;

use App\Services\Utils\FileManager;
use App\Entity\EvalRequest;
use App\Entity\ProjectRequest;
use App\Form\EvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\LogManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

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
     * @Route("/new/{id}", name="eval_request_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileManager $fileManager,ProjectRequest $projectRequest, LogManager $log): Response {
        $evalRequest = new EvalRequest();
        $form = $this->createForm(EvalRequestType::class, $evalRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $tempFiles = $form->get("fakeFiles")->getData();

            $projectDir = $this->getParameter('brochures_directory');
            
            $files = $fileManager->uploadFiles($tempFiles, $projectDir);

            $finish = $form->get("form_finish_input")->getData();

            $evalRequest->setRequest($projectRequest);
            $evalRequest->setDate(new \DateTime());

            $evalRequest->setFiles($files);

            if ($finish == "1") {
                $evalRequest->setCurrent(true);
                $projectRequest->setState($evalRequest->getStatus());
                
                $logData = array(
                    "description" => $evalRequest->getStatus()->getDescription(),
                    "request" => $projectRequest,
                    "observations" => $evalRequest->getObservations()
                );
                $log->insertLog($logData);
            } else {
            $evalRequest->setCurrent(false);
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
     * @Route("/{id}/edit/{id_request}", name="eval_request_edit", methods={"GET","POST"})
     * @Entity("projectRequest", expr="repository.find(id_request)")
     */
    public function edit(Request $request, EvalRequest $evalRequest, ProjectRequest $projectRequest): Response {
        $form = $this->createForm(EvalRequestType::class, $evalRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $finish = $form->get("form_finish_input")->getData();
      
            $evalRequest->setDate(new \DateTime());
            
            if ($finish == "1") {
                $evalRequest->setCurrent(true);
                $projectRequest->setState($evalRequest->getStatus());
                $logData = array(
                    "description" => $evalRequest->getStatus()->getDescription(),
                    "request" => $projectRequest,
                    "observations" => $evalRequest->getObservations()
                );
                $log->insertLog($logData);
            } else {
                $evalRequest->setCurrent(false);
            }

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

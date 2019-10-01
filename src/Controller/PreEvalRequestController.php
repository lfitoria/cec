<?php

namespace App\Controller;

use App\Entity\PreEvalRequest;
use App\Entity\ProjectRequest;
use App\Form\PreEvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pre/eval/request")
 */
class PreEvalRequestController extends AbstractController {

  /**
   * @Route("/", name="pre_eval_request_index", methods={"GET"})
   */
  public function index(): Response {
    $preEvalRequests = $this->getDoctrine()
            ->getRepository(PreEvalRequest::class)
            ->findAll();

    return $this->render('pre_eval_request/index.html.twig', [
                'pre_eval_requests' => $preEvalRequests,
    ]);
  }

  /**
   * @Route("/new/{id}", name="pre_eval_request_new", methods={"GET","POST"})
   */
  public function new(Request $request, ProjectRequest $projectRequest): Response {
    $preEvalRequest = new PreEvalRequest();
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();

      $finish = $form->get("form_finish_input")->getData();
      
      $preEvalRequest->setRequest($projectRequest);
      $preEvalRequest->setDate(new \DateTime());
      
      if ($finish == "1") {
        $preEvalRequest->setCurrent(true);
      } else {
        $preEvalRequest->setCurrent(false);
        $preEvalRequest->setStatus(null);
      }


      $entityManager->persist($preEvalRequest);

      $entityManager->flush();

      return $this->redirectToRoute('pre_eval_request_index');
    }

    return $this->render('pre_eval_request/new.html.twig', [
                'pre_eval_request' => $preEvalRequest,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="pre_eval_request_show", methods={"GET"})
   */
  public function show(PreEvalRequest $preEvalRequest): Response {
    return $this->render('pre_eval_request/show.html.twig', [
                'pre_eval_request' => $preEvalRequest,
    ]);
  }

  /**
   * @Route("/{id}/edit", name="pre_eval_request_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, PreEvalRequest $preEvalRequest): Response {
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('pre_eval_request_index', [
                  'id' => $preEvalRequest->getId(),
      ]);
    }

    return $this->render('pre_eval_request/edit.html.twig', [
                'pre_eval_request' => $preEvalRequest,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="pre_eval_request_delete", methods={"DELETE"})
   */
  public function delete(Request $request, PreEvalRequest $preEvalRequest): Response {
    if ($this->isCsrfTokenValid('delete' . $preEvalRequest->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($preEvalRequest);
      $entityManager->flush();
    }

    return $this->redirectToRoute('pre_eval_request_index');
  }

}

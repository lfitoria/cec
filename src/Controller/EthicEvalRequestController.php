<?php

namespace App\Controller;

use App\Entity\EthicEvalRequest;
use App\Entity\ProjectRequest;
use App\Form\EthicEvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\FileManager;

/**
 * @Route("/ethic/eval/request")
 */
class EthicEvalRequestController extends AbstractController {

  /**
   * @Route("/", name="ethic_eval_request_index", methods={"GET"})
   */
  public function index(): Response {
    $ethicEvalRequests = $this->getDoctrine()
            ->getRepository(EthicEvalRequest::class)
            ->findAll();

    return $this->render('ethic_eval_request/index.html.twig', [
                'ethic_eval_requests' => $ethicEvalRequests,
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
   * @Route("/new/{id}", name="ethic_eval_request_new", methods={"GET","POST"})
   */
  public function new(Request $request, FileManager $fileManager, ProjectRequest $projectRequest): Response {
    $ethicEvalRequest = new EthicEvalRequest();
    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $this->getDoctrine()->getManager();

      $informedConsentUploadedFiles = $form->get("informedConsentFiles")->getData();
      $informedAssentUploadedFiles = $form->get("informedAssentFiles")->getData();
      $collectionInformationUploadedFiles = $form->get("collectionInformationFiles")->getData();

      $projectDir = $this->getParameter('brochures_directory');

      $informedConsentFiles = $fileManager->uploadFiles($informedConsentUploadedFiles, $projectDir, "informedConsentFiles");
      $informedAssentFiles = $fileManager->uploadFiles($informedAssentUploadedFiles, $projectDir, "informedAssentFiles");
      $collectionInformationFiles = $fileManager->uploadFiles($collectionInformationUploadedFiles, $projectDir, "collectionInformationFiles");

      $ethicEvalRequest->setEthicEvalFiles(array_merge($informedConsentFiles, $informedAssentFiles, $collectionInformationFiles));
      $ethicEvalRequest->setRequest($projectRequest);

      $entityManager->persist($ethicEvalRequest);
      $entityManager->flush();

      $target = $form->get("form_target_input")->getData();

      $route = $this->getTargetRoute($target);
      $data = ['id' => $ethicEvalRequest->getRequest()->getId()];

      return $this->redirectToRoute($route, $data);
    }

    return $this->render('ethic_eval_request/new.html.twig', [
                'ethic_eval_request' => $ethicEvalRequest,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="ethic_eval_request_show", methods={"GET"})
   */
  public function show(EthicEvalRequest $ethicEvalRequest): Response {
    return $this->render('ethic_eval_request/show.html.twig', [
                'ethic_eval_request' => $ethicEvalRequest,
    ]);
  }

  /**
   * @Route("/{id}/edit", name="ethic_eval_request_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, EthicEvalRequest $ethicEvalRequest, FileManager $fileManager): Response {
    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest);
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        
      $informedConsentUploadedFiles = $form->get("informedConsentFiles")->getData();
      $informedAssentUploadedFiles = $form->get("informedAssentFiles")->getData();
      $collectionInformationUploadedFiles = $form->get("collectionInformationFiles")->getData();

      $projectDir = $this->getParameter('brochures_directory');

      $informedConsentFiles = $fileManager->uploadFiles($informedConsentUploadedFiles, $projectDir, "informedConsentFiles");
      $informedAssentFiles = $fileManager->uploadFiles($informedAssentUploadedFiles, $projectDir, "informedAssentFiles");
      $collectionInformationFiles = $fileManager->uploadFiles($collectionInformationUploadedFiles, $projectDir, "collectionInformationFiles");
     
      $ethicEvalRequest->addEthicEvalFiles(array_merge($informedConsentFiles, $informedAssentFiles, $collectionInformationFiles));
      
      $this->getDoctrine()->getManager()->flush();

      $target = $form->get("form_target_input")->getData();

      $route = $this->getTargetRoute($target);
      $data = ['id' => $ethicEvalRequest->getRequest()->getId()];

      return $this->redirectToRoute($route, $data);
    }

    return $this->render('ethic_eval_request/edit.html.twig', [
                'ethic_eval_request' => $ethicEvalRequest,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="ethic_eval_request_delete", methods={"DELETE"})
   */
  public function delete(Request $request, EthicEvalRequest $ethicEvalRequest): Response {
    if ($this->isCsrfTokenValid('delete' . $ethicEvalRequest->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($ethicEvalRequest);
      $entityManager->flush();
    }

    return $this->redirectToRoute('ethic_eval_request_index');
  }

}

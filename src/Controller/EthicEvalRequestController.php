<?php

namespace App\Controller;

use App\Entity\EthicEvalRequest;
use App\Entity\ProjectRequest;
use App\Form\EthicEvalRequestType;
use App\Entity\Criterion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\FileManager;
use App\Services\Utils\NotificationManager;
use App\Services\Utils\LogManager;
use App\Entity\LdapUser;
use Symfony\Component\Security\Core\Security;

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
        $route = 'project_request_index';
        break;
    }
    return $route;
  }

  /**
   * @Route("/new/{id}", name="ethic_eval_request_new", methods={"GET","POST"})
   */
  public function new(Request $request, FileManager $fileManager, NotificationManager $notificationManager, ProjectRequest $projectRequest, Security $security, LogManager $log): Response {
    $ethicEvalRequest = new EthicEvalRequest();
    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $finish = $form->get("form_finish_input")->getData();
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

      if ($finish == "1") {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(28);
        $loggedUser = $security->getUser();
        $role = $loggedUser->getRole()->getDescription();
        // $body_html = '<img src="http://catedrahumboldt.ucr.ac.cr/cec/public/images/logo_correo.png" alt="">
        //               <hr>
        //               <p>Se ha recibido una nueva solicitud de revisión con el número CEC-'.$projectRequest->getId().'</p>
        //               <p><strong>Proyecto: </strong>'.$projectRequest->getTitle().'</p>
        //               <p><strong>Unidad: </strong>'.$projectRequest->getProjectUnit().'</p>
        //               <p><strong>Investigador/estudiante responsable:</strong> '.$projectRequest->getTutorName().'</p>
        //               <a href="#" target="_blank">Asignar a evaluador</a>
        //               ';
        $body_html = '<img src="http://catedrahumboldt.ucr.ac.cr/cec/public/images/logo_header_ucr.png" alt="">
                      <br>
                      <img src="http://catedrahumboldt.ucr.ac.cr/cec/public/images/logo_correo.png" alt="">
                      <hr>
                      <p>Se ha recibido una nueva solicitud de revisión con el número CEC-' . $projectRequest->getId() . '</p>
                      <p><strong>Proyecto: </strong>' . $projectRequest->getTitle() . '</p>
                      <p><strong>Unidad: </strong>' . $projectRequest->getProjectUnit() . '</p>
                      <p><strong>Investigador/estudiante responsable:</strong> ' . $loggedUser->getName() . '</p>
                      <a href="' . $request->headers->get('host') . $this->generateUrl('project_request_index') . '" target="_blank">Asignar a evaluador</a>
                      
                      ';
        $emailData = [
            "subject" => "Nueva solicitud",
            "from" => "catedrahumboldt.vi@ucr.ac.cr",
            "to" => "lfitoria@eldomo.net",
            // "to" => "camacho.le@gmail.com",
            "cc" => "camacho.le@gmail.com",
            "body" => $body_html
        ];
        // var_dump($emailData);
        // die();
        $notificationManager->sendEmail($emailData);
        $logData = array(
            "description" => "Enviada por solicitante",
            "request" => $projectRequest
        );
        $log->insertLog($logData);
      } else {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      }

      $ethicEvalRequest->getRequest()->setState($state);

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
  public function edit(Request $request, EthicEvalRequest $ethicEvalRequest, FileManager $fileManager, NotificationManager $notificationManager, LogManager $log): Response {
    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $finish = $form->get("form_finish_input")->getData();

      $informedConsentUploadedFiles = $form->get("informedConsentFiles")->getData();
      $informedAssentUploadedFiles = $form->get("informedAssentFiles")->getData();
      $collectionInformationUploadedFiles = $form->get("collectionInformationFiles")->getData();

      $projectDir = $this->getParameter('brochures_directory');

      $informedConsentFiles = $fileManager->uploadFiles($informedConsentUploadedFiles, $projectDir, "informedConsentFiles");
      $informedAssentFiles = $fileManager->uploadFiles($informedAssentUploadedFiles, $projectDir, "informedAssentFiles");
      $collectionInformationFiles = $fileManager->uploadFiles($collectionInformationUploadedFiles, $projectDir, "collectionInformationFiles");

      $ethicEvalRequest->addEthicEvalFiles(array_merge($informedConsentFiles, $informedAssentFiles, $collectionInformationFiles));

      if ($finish == "1") {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(28);
        $emailData = [
            "subject" => "TEST",
            "from" => "catedrahumboldt.vi@ucr.ac.cr",
            "to" => "lfitoria@eldomo.net",
            // "to" => "camacho.le@gmail.com",
            "cc" => "camacho.le@gmail.com",
            "body" => "BODY TEST public function edit"
        ];
        $notificationManager->sendEmail($emailData);
        $logData = array(
            "description" => "Enviada por solicitante",
            "request" => $ethicEvalRequest->getRequest()
        );
        $log->insertLog($logData);
      } else {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(27);
      }

      $ethicEvalRequest->getRequest()->setState($state);

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

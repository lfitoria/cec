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
      $aditionalFilesUploadedFiles = $form->get("aditionalFilesFiles")->getData();

      $projectDir = $this->getParameter('brochures_directory');

      $informedConsentFiles = $fileManager->uploadFiles($informedConsentUploadedFiles, $projectDir, "informedConsentFiles");
      $informedAssentFiles = $fileManager->uploadFiles($informedAssentUploadedFiles, $projectDir, "informedAssentFiles");
      $collectionInformationFiles = $fileManager->uploadFiles($collectionInformationUploadedFiles, $projectDir, "collectionInformationFiles");
      // aditionalFiles
      $aditionalFiles = $fileManager->uploadFiles($aditionalFilesUploadedFiles, $projectDir, "aditionalFiles");

      $mtaUploadedFiles = $form->get("mtaFiles")->getData();
      $mtaFiles = $fileManager->uploadFiles($mtaUploadedFiles, $projectDir, "mtaFiles");

      $ethicEvalRequest->setEthicEvalFiles(array_merge($informedConsentFiles, $informedAssentFiles, $collectionInformationFiles,$aditionalFiles,$mtaFiles));

      $ethicEvalRequest->setRequest($projectRequest);

      if ($finish == "1") {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(28);
        $loggedUser = $security->getUser();
        $role = $loggedUser->getRole()->getDescription();
        
        $correos = array();

        array_push($correos, "lfitoria@eldomo.net");
        array_push($correos, "camacho.le@gmail.com");
        
        $emailData = [
            "subject" => "Nueva solicitud",
            "from" => "cec@ucr.ac.cr",
            //"from" => "jonathan.rojas@ucr.ac.cr",
            "to" => "daihanna.hernandez@ucr.ac.cr",
            //"to" => "luisfitoria91@gmail.com",
            //"cc" => $correos,
            //"body" => "body"
            "body" => $this->render('emails/evaluatorAssigment.html.twig', [
              'project_request' => $projectRequest,
              'details_eval' => ''
            ])

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
  public function edit(Request $request, EthicEvalRequest $ethicEvalRequest, FileManager $fileManager, NotificationManager $notificationManager, LogManager $log, ProjectRequest $projectRequest): Response {
    $form = $this->createForm(EthicEvalRequestType::class, $ethicEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $finish = $form->get("form_finish_input")->getData();

      $informedConsentUploadedFiles = $form->get("informedConsentFiles")->getData();
      $informedAssentUploadedFiles = $form->get("informedAssentFiles")->getData();
      $collectionInformationUploadedFiles = $form->get("collectionInformationFiles")->getData();
      $aditionalFilesUploadedFiles = $form->get("aditionalFilesFiles")->getData();

      $projectDir = $this->getParameter('brochures_directory');

      $informedConsentFiles = $fileManager->uploadFiles($informedConsentUploadedFiles, $projectDir, "informedConsentFiles");
      $informedAssentFiles = $fileManager->uploadFiles($informedAssentUploadedFiles, $projectDir, "informedAssentFiles");
      $collectionInformationFiles = $fileManager->uploadFiles($collectionInformationUploadedFiles, $projectDir, "collectionInformationFiles");
      // aditionalFiles
      $aditionalFiles = $fileManager->uploadFiles($aditionalFilesUploadedFiles, $projectDir, "aditionalFiles");

      $mtaUploadedFiles = $form->get("mtaFiles")->getData();
      $mtaFiles = $fileManager->uploadFiles($mtaUploadedFiles, $projectDir, "mtaFiles");

      $ethicEvalRequest->addEthicEvalFiles(array_merge($informedConsentFiles, $informedAssentFiles, $collectionInformationFiles, $aditionalFiles,$mtaFiles));

      if ($finish == "1") {
        $state = $this->getDoctrine()->getRepository(Criterion::class)->find(28);
        
        $emailData = [
            "subject" => "Nueva solicitud",
            "from" => "cec@ucr.ac.cr",
            //"from" => "jonathan.rojas@ucr.ac.cr",
            "to" => "daihanna.hernandez@ucr.ac.cr",
            //"to" => "luisfitoria91@gmail.com",
            "cc" => "lfitoria@eldomo.net",
            "body" => $this->render('emails/evaluatorAssigment.html.twig', [
              'project_request' => $projectRequest,
              'details_eval' => ''
            ])
        ];
        
        $notificationManager->sendEmail($emailData);

        $logData = array(
            "description" => "Enviada/Editado por solicitante",
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

  /**
   * @Route("/emailTestSend/email", name="emailtestsend", methods={"GET","POST"})
   */
  public function emailTestSend(Request $request, NotificationManager $notificationManager ): Response {
    echo "entra";
    
    //$projectRequest = $this->getDoctrine()->getRepository(ProjectRequest::class)->find(53);
    // var_dump($projectRequest);
    // die();
    $emailData = [
      "subject" => "Nueva solicitud",
      "from" => "cec@ucr.ac.cr",
      // "from" => "jonathan.rojas@ucr.ac.cr",
      "to" => "lfitoria@eldomo.net",
      // "to" => "camacho.le@gmail.com",
      //"cc" => "camacho.le@gmail.com",
      "body" => "body"
    ];
    // var_dump($emailData);
    // 
    $notificationManager->sendEmail($emailData);

    
    die();
    return $this->render('ethic_eval_request/show.html.twig', [
                'ethic_eval_request' => $ethicEvalRequest,
    ]);
  }

}

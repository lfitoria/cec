<?php

namespace App\Controller;

use App\Entity\PreEvalRequest;
use App\Entity\ProjectRequest;
use App\Form\PreEvalRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use App\Services\Utils\LogManager;
use App\Services\Utils\NotificationManager;
use App\Services\Utils\ExternalDataManager;

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
  public function new(Request $request, ProjectRequest $projectRequest, LogManager $log,NotificationManager $notificationManager,ExternalDataManager $externalDataManager): Response {
    // var_dump($projectRequest->getOwner()->getEmail());
    // die();
    $preEvalRequest = new PreEvalRequest();
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      $finish = $form->get("form_finish_input")->getData();

      // object
      $status = $form->get("status")->getData()->getId();

      // var_dump($finish);
      // var_dump($preEvalRequest->getStatus());
      // die();
      
      $preEvalRequest->setRequest($projectRequest);
      $preEvalRequest->setDate(new \DateTime());
      
      if ($finish == "1") {
        $preEvalRequest->setCurrent(true);
        // $projectRequest->setState($preEvalRequest->getStatus());

        switch ($status) {
          case '31':
              $subjectEmail = "Solicitud: ".$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '32':
              $subjectEmail = "Solicitud: ".$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '33':
              $subjectEmail = "Solicitud: ".$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '34':
              $subjectEmail = "Solicitud: ".$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '35':
              $subjectEmail = "Solicitud: ".$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          
          default:
  
            break;
        }
        $entityManager = $this->getDoctrine()->getManager('sip');
        $emOracle = $this->getDoctrine()->getManager('oracle');

        // $projectData = $externalDataManager->getProjectInfoByCode($entityManager, $projectCode);
        var_dump($projectRequest->getUacademica());
        
        $vinculo = $externalDataManager->getProjectInfoByCode($emOracle, $projectRequest->getSipProject());

        $unit = $externalDataManager->getUnitInfoByIDA($entityManager, $projectRequest->getUacademica());
        
        echo "<pre>";
        var_dump($vinculo);
        echo "</pre>";
        
        $gestor1 = $externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoru"]);
        $gestor2 = $externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoric"]);

        // var_dump($gestor1);
        // var_dump($gestor2);
        // var_dump($gestor1["0"]["correo"]);
        // var_dump($gestor2["0"]["correo"]);
        // die();
        
        $correos = array();

        array_push($correos, "gabriela.chaconzamora@ucr.ac.cr");

        $emailData = [
          "subject" => $subjectEmail,
          "from" => "catedrahumboldt.vi@ucr.ac.cr",
          // "to" => $projectRequest->getOwner()->getEmail(),
          "to" => "luisfitoria91@gmail.com",
          "cc" => "lfitoria@eldomo.net",
          "body" => $this->render('emails/evaluatorAssigment.html.twig', [
          'project_request' => $projectRequest,
          'details_eval' => $preEvalRequest->getObservations(),
          ])
        ];
      
        $notificationManager->sendEmail($emailData);
        $logData = array(
          "description" => $preEvalRequest->getStatus()->getDescription(),
          "request" => $projectRequest,
          "observations" => $preEvalRequest->getObservations()
        );
        $log->insertLog($logData);
        

      } else {
        $preEvalRequest->setCurrent(false);
        // $projectRequest->setState($preEvalRequest->getStatus());
        
      }

      // var_dump($preEvalRequest);
      // die();

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($preEvalRequest);
      $entityManager->flush();
      
      return $this->redirectToRoute('project_request_index');
      // return $this->redirectToRoute('pre_eval_request_index');
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
   * @Route("/{id}/edit/{id_request}", name="pre_eval_request_edit", methods={"GET","POST"})
   * @Entity("projectRequest", expr="repository.find(id_request)")
   */
  public function edit(Request $request, PreEvalRequest $preEvalRequest ,ProjectRequest $projectRequest, LogManager $log): Response {
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      $finish = $form->get("form_finish_input")->getData();
      
      $preEvalRequest->setDate(new \DateTime());
      
      if ($finish == "1") {
        $preEvalRequest->setCurrent(true);
        $projectRequest->setState($preEvalRequest->getStatus());
        $logData = array(
            "description" => $preEvalRequest->getStatus()->getDescription(),
            "request" => $projectRequest,
            "observations" => $preEvalRequest->getObservations()
        );
        $log->insertLog($logData);
      } else {
        $preEvalRequest->setCurrent(false);
      }
      
      $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('project_request_index');
      
      // return $this->redirectToRoute('pre_eval_request_index', [
      //             'id' => $preEvalRequest->getId(),
      // ]);
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

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
    //var_dump($projectRequest->getOwner()->getEmail());
    //die();
    $preEvalRequest = new PreEvalRequest();
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $finish = $form->get("form_finish_input")->getData();
      $status = $form->get("status")->getData()->getId();
      $preEvalRequest->setRequest($projectRequest);
      $preEvalRequest->setDate(new \DateTime());
      
      if ($finish == "1") {
        $preEvalRequest->setCurrent(true);
        $fecha = $projectRequest->getDate();
        $f = date_format($fecha,"Y");
        $fYear = substr($f,-2);
        $subject = "Estado de solicitud: CEC-".$projectRequest->getId()."-".$fYear.": ";

        switch ($status) {
          case '31':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '32':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '33':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '34':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '35':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          
          default:
  
            break;
        }
        $entityManager = $this->getDoctrine()->getManager('sip');
        $emOracle = $this->getDoctrine()->getManager('oracle');
        $unit = $externalDataManager->getUnitInfoByIDA($entityManager, $projectRequest->getUacademica());
        
        //$gestor1 =$externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoru"]);
        //$gestor2 =$externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoric"]);
        
        $correos = array();
        
        if ( isset($gestor1["0"]["correo"])){
            array_push($correos, trim($gestor1["0"]["correo"]));
        }
        if ( isset($gestor2["0"]["correo"])){
          if( $gestor1["0"]["correo"] !== $gestor2["0"]["correo"] ){
            array_push($correos, trim($gestor2["0"]["correo"]));
          }
        }

        array_push($correos, "lfitoria@eldomo.net");
        // array_push($correos, "camacho.le@gmail.com");
        // var_dump($correos);
        $emailData = [
          "subject" => $subjectEmail,
          "from" => "cec@ucr.ac.cr",
          //"from" => "jonathan.rojas@ucr.ac.cr",
          "to" => $projectRequest->getOwner()->getEmail(),
          //"to" => "luisfitoria91@gmail.com",
          "cc" => $correos,
          "body" => $this->render('emails/evaluatorAssigment.html.twig', [
          'project_request' => $projectRequest,
          'details_eval' => $preEvalRequest->getObservations(),
          'state' => $preEvalRequest->getStatus()->getDescription()
          ])
        ];
        
        if($status !== '31'){
          $notificationManager->sendEmail($emailData);
        }
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

      //var_dump($preEvalRequest);
      //die();

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
  public function edit(Request $request, PreEvalRequest $preEvalRequest ,ProjectRequest $projectRequest, LogManager $log, ExternalDataManager $externalDataManager, NotificationManager $notificationManager): Response {
    $form = $this->createForm(PreEvalRequestType::class, $preEvalRequest);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      
      $finish = $form->get("form_finish_input")->getData();
      $status = $form->get("status")->getData()->getId();
      
      $preEvalRequest->setDate(new \DateTime());
      
      if ($finish == "1") {
        $preEvalRequest->setCurrent(true);
        $projectRequest->setState($preEvalRequest->getStatus());
        // --
        $fecha = $projectRequest->getDate();
        $f = date_format($fecha,"Y");
        $fYear = substr($f,-2);
        $subject = "Estado de solicitud: CEC-".$projectRequest->getId()."-".$fYear.": ";

        switch ($status) {
          case '31':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '32':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '33':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '34':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          case '35':
              $subjectEmail = $subject.$preEvalRequest->getStatus()->getDescription();
              $projectRequest->setState($preEvalRequest->getStatus());
            break;
          
          default:
  
            break;
        }
        $entityManager = $this->getDoctrine()->getManager('sip');
        $emOracle = $this->getDoctrine()->getManager('oracle');
        $unit = $externalDataManager->getUnitInfoByIDA($entityManager, $projectRequest->getUacademica());        
        
        //$gestor1 =$externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoru"]);
        //$gestor2 =$externalDataManager->getGestoresByID($entityManager, $unit["0"]["gestoric"]);
        
        $correos = array();
        
        if ( isset($gestor1["0"]["correo"])){
            array_push($correos, trim($gestor1["0"]["correo"]));
        }
        if ( isset($gestor2["0"]["correo"])){
          if( $gestor1["0"]["correo"] !== $gestor2["0"]["correo"] ){
            array_push($correos, trim($gestor2["0"]["correo"]));
          }
        }
        
        array_push($correos, "lfitoria@eldomo.net");
        // array_push($correos, "camacho.le@gmail.com");

        $emailData = [
          "subject" => $subjectEmail,
          "from" => "cec@ucr.ac.cr",
          //"from" => "jonathan.rojas@ucr.ac.cr",
          "to" => $projectRequest->getOwner()->getEmail(),
          //"to" => "luisfitoria91@gmail.com",
          "cc" => $correos,
          "body" => $this->render('emails/evaluatorAssigment.html.twig', [
          'project_request' => $projectRequest,
          'details_eval' => $preEvalRequest->getObservations(),
          'state' => $preEvalRequest->getStatus()->getDescription()
          ])
        ];
        
        if($status !== '31'){
          $notificationManager->sendEmail($emailData);
        }
        // ----------
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

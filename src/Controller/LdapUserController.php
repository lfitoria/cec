<?php

namespace App\Controller;

use App\Entity\LdapUser;
use App\Entity\ProjectRequest;
use App\Form\LdapUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\Utils\NotificationManager;
use App\Services\Utils\LogManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Route("/ldap/user")
 */
class LdapUserController extends AbstractController {

  /**
   * @Route("/", name="ldap_user_index", methods={"GET"})
   */
  public function index(): Response {
    $ldapUsers = $this->getDoctrine()
            ->getRepository(LdapUser::class)
            ->findAll();

    return $this->render('ldap_user/index.html.twig', [
                'ldap_users' => $ldapUsers,
    ]);
  }

  /**
   * @Route("/new", name="ldap_user_new", methods={"GET","POST"})
   */
  public function new(Request $request, UserPasswordEncoderInterface $encoder, LogManager $log, ContainerInterface $container): Response {
    $ldapUser = new LdapUser();
    $form = $this->createForm(LdapUserType::class, $ldapUser);
    $form->handleRequest($request);

    $error = false;

    // var_dump($request->get('error'));
    // die();

    // if ($request->get('error') == '1') {
    //   $error = true;
    // }

    $this->container = $container;
    $objUserServ = $this->container->get('user_manager');

    if ($form->isSubmitted() && $form->isValid()) {


      if (!$objUserServ->checkUserExists($form->get("email")->getData())) {

        $entityManager = $this->getDoctrine()->getManager();
        $objCurrentDatetime = new \Datetime();

        $objUser = new LdapUser();
        $objUser->setEmail($form->get("email")->getData());
        $objUser->setCreationDate($objCurrentDatetime);
        $objUser->setLastLoginDate($objCurrentDatetime);
        $objUser->setUsername($form->get("username")->getData());

        $passEncryp = $encoder->encodePassword($objUser, $form->get("password")->getData());

        // var_dump($passEncryp);
        // die();

        $objUser->setPassword($passEncryp);
        $objUser->setRole($form->get("role")->getData());
        $objUser->setCarnet($form->get("carnet")->getData());
        
        $objUser->setName($form->get("name")->getData());
        $objUser->setCedulaUsuario($form->get("cedula_usuario")->getData());
        $objUser->setExternal($form->get("external")->getData());

        $entityManager->persist($objUser);
        $entityManager->flush();


        $logData = array(
          "description" => "Insercion de usuario: ".$form->get("email")->getData(),
        );
        $log->insertLog($logData);

        return $this->redirectToRoute('ldap_user_index');
      }else{
        $this->addFlash(
          'notice',
          'Correo ya existe.'
        );
        return $this->redirectToRoute('ldap_user_new');
      }
    }

    return $this->render('ldap_user/new.html.twig', [
                'ldap_user' => $ldapUser,
                'form' => $form->createView(),

    ]);
  }

  /**
   * @Route("/{id}", name="ldap_user_show", methods={"GET"})
   */
  public function show(LdapUser $ldapUser): Response {
    return $this->render('ldap_user/show.html.twig', [
                'ldap_user' => $ldapUser,
    ]);
  }

  /**
   * @Route("/{id}/edit", name="ldap_user_edit", methods={"GET","POST"})
   */
  public function edit(Request $request, LdapUser $ldapUser): Response {
    $form = $this->createForm(LdapUserType::class, $ldapUser);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $this->getDoctrine()->getManager()->flush();

      return $this->redirectToRoute('ldap_user_index', [
                  'id' => $ldapUser->getId(),
      ]);
    }

    return $this->render('ldap_user/edit.html.twig', [
                'ldap_user' => $ldapUser,
                'form' => $form->createView(),
    ]);
  }

  /**
   * @Route("/{id}", name="ldap_user_delete", methods={"DELETE"})
   */
  public function delete(Request $request, LdapUser $ldapUser, LogManager $log): Response {
    if ($this->isCsrfTokenValid('delete' . $ldapUser->getId(), $request->request->get('_token'))) {
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->remove($ldapUser);
      $entityManager->flush();

      $logData = array(
        "description" => "Eliminación de usuario: ".$ldapUser->getEmail(),
      );
      $log->insertLog($logData);
    }

    return $this->redirectToRoute('ldap_user_index');
  }

  /**
   * @Route("/assigment_evaluator_to_request", name="assigment_evaluator_to_request", methods={"POST"})
   */
  public function assigmentEvaluatorToRequest(Request $request, NotificationManager $notificationManager, LogManager $log): Response {
    $evaluators = $request->request->get('evaluators');
    $projectId = $request->request->get('project_id');

    if ($evaluators) {
      $entityManager = $this->getDoctrine()->getManager();
      $newEvaluators = array();
      $emailEvaluators = array();
      $projectRequest = $this->getDoctrine()->getRepository(ProjectRequest::class)->find($projectId);
      
      foreach ($evaluators as $id) {
        $evaluator = $this->getDoctrine()->getRepository(LdapUser::class)->find($id);
        $newEvaluators[] = $evaluator;
        $emailEvaluators[] = $evaluator->getEmail();
        
      }
      

      $body = $this->renderView('emails/evaluatorAssigment.html.twig', ['project_request' => $projectRequest]);
      //evaluator@cec.com
      $emailData = [
          "subject" => "CEC – Solicitud de revisión asignada - CEC-" . $projectRequest->getId(),
          "from" => "catedrahumboldt.vi@ucr.ac.cr",
          "to" => $emailEvaluators,
          // "cc" => "camacho.le@gmail.com",
          "cc" => "lfitoria@eldomo.net",
          "body" => $body
      ];
      $notificationManager->sendEmail($emailData);

      $projectRequest->setUsers($newEvaluators);
      $entityManager->flush();
      
      $logData = array(
          "description" => "Asignada a: " . implode (",", $newEvaluators),
          "request" => $projectRequest
      );
      $log->insertLog($logData);

      return new JsonResponse(['wasAssigned' => true]);
    }

    return new JsonResponse(['wasAssigned' => false]);
  }

}

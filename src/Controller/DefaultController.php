<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Entity\ProjectRequest;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\LdapUser;
use App\Services\Utils\LogManager;

class DefaultController extends AbstractController {

  /**
   * @Route("/indexold", name="indexold")
   */
  public function index() {
    $ss = new ProjectRequest();
    $ss->setTitle("Test");
    $user1 = new User();
    $user2 = new User();
    $ss->addUser($user1);
    $ss->addUser($user2);
    $entityManager = $this->getDoctrine()->getManager();
    $test = $entityManager->getRepository(ProjectRequest::class)->findOneBy(array('id' => 1));
    // var_dump($test);
    // die();

    return $this->render('default/index.html.twig', [
                'controller_name' => 'DefaultController',
                'test' => $test,
    ]);
  }

  

  /**
   * @Route("/", name="default")
   */
  public function login(ContainerInterface $container, Request $request, AuthenticationUtils $authUtils,UserPasswordEncoderInterface $encoder,Security $security) {
    // $loggedUser = $security->getUser();
    // var_dump($loggedUser);
    // die();
    if ($this->getUser() != null) {
      return $this->redirectToRoute('project_request_index');
    } else {
      $arrViewData = array('USER_EMAIL' => NULL, 'PASSWORD' => NULL, 'ERROR' => NULL);
      $this->container = $container;
      $objUserServ = $this->container->get('user_manager');
      
      // Checks if the login form has been submitted
      if ($request->getMethod() == 'POST') {

        $email = $request->get('email');
        $password = $request->get('password');
        $evaluator = $request->get('evaluator');

        // var_dump($evaluator);
        // die();

        if ($objUserServ->checkUserExists($email)) {
          
          if ($encoder->isPasswordValid($objUserServ->getUser($email), $password)) {
            // echo "entra";
            $objUserServ->loginAction(array(
              "cedula" => $email,
              "opt_eval_form" => $evaluator
            ));
            return $this->redirectToRoute('project_request_index');

          }else{
            $this->addFlash(
              'notice',
              'Usuario incorrecto.'
            );
            return $this->redirectToRoute('login');
          }
          
        }

        // echo "login solo en local";
        // die();

        $objLdapServ = $this->get('ldap');
        $arrLoginResult = $objLdapServ->login($evaluator);
        // Ldap login result
        $arrViewData = json_decode($arrLoginResult, TRUE);

        if (!empty($arrViewData['ERROR']) ) {
          $this->addFlash(
            'notice',
            'Usuario incorrecto.'
          );
          return $this->redirectToRoute('login');
        }

        if ($arrViewData['USERNAME'] != null) {
          // $loggedUser = $security->getUser();
          // var_dump($loggedUser);
          // echo "<hr>";
          // var_dump($this->getUser());
          // die();
          return $this->redirectToRoute('project_request_index');
        }else{
          $this->addFlash(
            'notice',
            'Usuario incorrecto.'
          );
          return $this->redirectToRoute('login');
        }
      }
    }

    return $this->render('default/login.html.twig', $arrViewData);
  }

  /**
   * @Route("/validate_user_send", name="validate_user_send", methods={"POST"})
   */
  public function ValidateUserSendProject(ContainerInterface $container, Request $request, AuthenticationUtils $authUtils, Security $security, UserPasswordEncoderInterface $encoder): Response {
    $data = $request->request->all();

    // var_dump($data);
    // die();

    if( $data["email"] !== "student@cec.com" ){
      $this->container = $container;

      $arrViewData = array('USER_EMAIL' => NULL, 'PASSWORD' => NULL, 'ERROR' => NULL);
      if ($request->getMethod() == 'POST') {
        
        $email = $request->get('email');
        $password = $request->get('password');
        $objUserServ = $this->container->get('user_manager');

        if ($objUserServ->checkUserExists($email)) {
          
          if ($encoder->isPasswordValid($objUserServ->getUser($email), $password)) {
            // echo "entra";
            return new JsonResponse(['wasAssigned' => true]);
            

          }else{
            return new JsonResponse(['wasAssigned' => false]);
          }
          
        }


        // load Ldap service
        $objLdapServ = $this->get('ldap');

        $arrLoginResult = $objLdapServ->login();

        // Ldap login result
        $arrViewData = json_decode($arrLoginResult, TRUE);

        $loggedUser = $security->getUser();
        $userName = $loggedUser->getName();


        if ( isset($arrViewData['USERNAME']) ) {
          // var_dump($arrViewData);
          $arrViewData_cut = $this->getbeforename('@', $arrViewData["USERNAME"]);
          // var_dump($arrViewData_cut);
        }else{
          $arrViewData_cut = "";
        }


        // echo "</pre>";


        $arrViewData_cut_lower = strtolower($arrViewData_cut);

        if ( $data["email"] ==  $arrViewData_cut_lower) {
          // echo "entra";
          return new JsonResponse(['wasAssigned' => true]);
        }else{
          // echo "no entra";
          return new JsonResponse(['wasAssigned' => false]);
        }

      }
    }else{
      return new JsonResponse(['wasAssigned' => true]);
    }
    
  }

  private function getbeforename ($name, $inthat){
        return substr($inthat, 0, strpos($inthat, $name));
  }

  /**
   * @Route("/logout", name="app_logout", methods={"GET"})
   */
  public function logout() {
    // controller can be blank: it will never be executed!
    throw new \Exception('Don\'t forget to activate logout in security.yaml');
  }

  /**
   * @Route("/login_test/{type}", name="login_test", methods={"GET"})
   */
  public function loginTest(ContainerInterface $container, $type,Request $request) {
    $this->container = $container;
    $objUserServ = $this->container->get('user_manager');
    $email = '';
    switch ($type) {
      case "admin":
        $email = "admin@cec.com";
        break;
      case "student":
        $email = "student@cec.com";
        break;
      case "researcher":
        $email = "researcher@cec.com";
        break;
      case "evaluator":
        $email = "evaluator@cec.com";
        break;
      default:
        $email = "admin@cec.com";
        break;
    }
    $evaluator = $request->get('evaluator');
    $objUserServ->loginAction(array(
        "cedula" => $email,
        "opt_eval_form" => $evaluator
    ));

    return $this->redirectToRoute('project_request_index');
  }
  /**
   * @Route("/ayuda", name="ayuda")
   */
  public function ayuda() {

    return $this->render('default/ayuda.html.twig');
  }

}

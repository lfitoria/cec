<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Entity\ProjectRequest;
use Symfony\Component\DependencyInjection\ContainerInterface;

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

  // * @Route("/login", name="login")

  /**
   * @Route("/", name="default")
   */
  public function login(ContainerInterface $container, Request $request, AuthenticationUtils $authUtils) {

    if ($this->getUser() != null) {
      return $this->redirectToRoute('project_request_index_admin');
    } else {
      $arrViewData = array('USER_EMAIL' => NULL, 'PASSWORD' => NULL, 'ERROR' => NULL);
      $this->container = $container;
      // Checks if the login form has been submitted
      if ($request->getMethod() == 'POST') {
        // load Ldap service
        $objLdapServ = $this->get('ldap');

        $arrLoginResult = $objLdapServ->login();

        // Ldap login result
        $arrViewData = json_decode($arrLoginResult, TRUE);

        // check Ldap login result
        // var_dump($arrLoginResult);
        // var_dump($arrViewData);
        // die();

        if ($arrViewData['USERNAME'] != null) {
          // user logged ok, then we redirect to the home page
          // echo "entra";
          // die();
          // $router = $this->get('router');
          // $url = $router->generate('home');
          //return $this->redirect($url);
          return $this->redirectToRoute('project_request_index_admin');
        }
      }
    }

    return $this->render('default/login.html.twig', $arrViewData);
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
  public function loginTest(ContainerInterface $container, $type) {
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
    
    $objUserServ->loginAction(array(
        "cedula" => $email,
    ));

    return $this->redirectToRoute('project_request_index_admin');
  }

}

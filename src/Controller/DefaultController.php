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
     * @Route("/", name="default")
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
     * @Route("/login", name="login")
     */
    public function login(ContainerInterface $container, Request $request, AuthenticationUtils $authUtils) {
        $arrViewData = array('USER_EMAIL' => NULL, 'PASSWORD' => NULL, 'ERROR' => NULL);
        $this->container = $container;
        // Checks if the login form has been submitted
        if ($request->getMethod() == 'POST') {
            // load Ldap service
            $objLdapServ = $this->get('ldap');

            // check Ldap login
            $arrLoginResult = $objLdapServ->login();

            // Ldap login result
            $arrViewData = json_decode($arrLoginResult, TRUE);

            // check Ldap login result

            var_dump($arrLoginResult);
            if ($arrViewData['LOGIN'] == "OK") {
                // user logged ok, then we redirect to the home page
                $router = $this->get('router');
                $url = $router->generate('home');

                return $this->redirect($url);
            }
        }



        return $this->render('default/login.html.twig', $arrViewData);
    }

}

<?php

// src/Services/User/UserManager.php

namespace App\Services\User;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use App\Entity\LdapUser;
// use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserManager {

    private $container, $em, $request, $session, $user;

    public function __construct(EntityManager $em, ContainerInterface $container, SessionInterface $session) {
        // $this->requestStack = $requestStack;
        $this->em = $em;
        // $this->request = $request;
        $this->container = $container;
        $this->session = $session;
    }

    // checks if user exists when login form has been submitted
    public function loginAction($strEmail) {
        if (!$this->checkUserExists($strEmail['cedula'])) {
            // create new user
            $this->createUser($strEmail['cedula']);
        }

        $this->createLoginSession();
    }

    // get user data from database
    public function getUser($strEmail) {
        return $this->em->getRepository(LdapUser::class)->findOneBy(array('email' => $strEmail));
    }

    // Check if a user exists on database
    public function checkUserExists($strEmail) {
        $this->user = $this->getUser($strEmail);
        return (!empty($this->user)) ? true : false;
    }

    // Create new user on database
    public function createUser($strEmail) {
        $boolResult = false;
        $objCurrentDatetime = new \Datetime();

        try {
            $role = $this->em->getRepository(RolesUsers::class)->find(1);
            
            $objUser = new LdapUser();
            $objUser->setEmail($strEmail);
            $objUser->setCreationDate($objCurrentDatetime);
            $objUser->setLastLoginDate($objCurrentDatetime);
            $objUser->setRole($role);
            // save data
            $this->em->persist($objUser);
            $this->em->flush();

            // result data
            $boolResult = true;

            // user obj
            $this->user = $objUser;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        return $boolResult;
    }

    // creates login session
    public function createLoginSession() {
        $objToken = new UsernamePasswordToken($this->user, null, 'main', $this->user->getRoles());

        // update user last login
        $this->user->setLastLoginDate(new \Datetime());
        $this->em->persist($this->user);
        $this->em->flush();

        // save token
        $objTokenStorage = $this->container->get("security.token_storage")->setToken($objToken);
        $this->session->set('_security_main', serialize($objToken));
    }

    // logout a user
    public function logOutUser() {
        $this->container->get('security.context')->setToken(null);
        $this->container->get('request')->getSession()->invalidate();

        $url = $router->generate('oportunidades');
        return $this->redirect($url);
    }

}

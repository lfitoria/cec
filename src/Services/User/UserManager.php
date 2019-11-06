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
use App\Entity\UsersRoles;
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
    // var_dump($strEmail);
    // die();
    // array(4) { ["cedula"]=> string(30) "xxxxx" ["id"]=> string(10) "0115190268" ["carnet"]=> string(6) "B04278" ["tipo_usuario_ldap"]=> array(2) { ["count"]=> int(1) [0]=> string(10) "ESTUDIANTE" } }

    

    if (!$this->checkUserExists($strEmail['cedula'])) {
      // create new user
      // $tipo_usuario
      $this->createUser($strEmail);
      
    }
    // var_dump($strEmail);
    // die();

    $this->createLoginSession($strEmail['opt_eval_form']);
  }

  // get user data from database
  public function getUser($strEmail) {
    return $this->em->getRepository(LdapUser::class)->findOneBy(array('email' => $strEmail));
    // var_dump($strEmail);
    // die();
  }
  public function getPass($strEmail) {
    return $this->em->getRepository(LdapUser::class)->findOneBy(array('email' => $strEmail));
    // var_dump($strEmail);
    // die();
  }

  // Check if a user exists on database
  public function checkUserExists($strEmail) {
    $this->user = $this->getUser($strEmail);
    // var_dump($strEmail);
    // die();
    return (!empty($this->user)) ? true : false;
  }

  // Create new user on database
  public function createUser($strEmail) {
    $boolResult = false;
    $objCurrentDatetime = new \Datetime();

    // echo "<pre>";
    // var_dump($tipo_usuario);
    // var_dump($tipo_usuario_ldap);
    // echo "</pre>";
    // die();

    try {

      if (isset($strEmail["tipo_usuario_ldap"][1]) && $strEmail["tipo_usuario_ldap"][1] == "DOCENTE") {
        $role_find = 3;
      } else {
        $role_find = 2;
      }

      // var_dump($role_find);
      // die();

      $role = $this->em->getRepository(UsersRoles::class)->find($role_find);

      $objUser = new LdapUser();
      $objUser->setEmail($strEmail["cedula"]);
      $objUser->setCreationDate($objCurrentDatetime);
      $objUser->setLastLoginDate($objCurrentDatetime);
      $objUser->setUsername(explode("@", $strEmail["cedula"])[0]);
      $objUser->setRole($role);
      $objUser->setCarnet($strEmail["carnet"]);
      $objUser->setName($strEmail["nombre"]);
      $objUser->setCedulaUsuario($strEmail["id"]);
      $objUser->setExternal(0);
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
  public function createLoginSession($opt_eval_form) {

    // var_dump($opt_eval_form);

    // var_dump($this->user);

    // var_dump($this->user->getRole()->getId());

    // if($this->user->getRole()->getId() == 4 && $opt_eval_form == 1){
    //   // $role = $this->em->getRepository(UsersRoles::class)->find(4);
    //   // $this->user->setRole($role);
    //   $objToken = new UsernamePasswordToken($this->user, null, 'main', $this->user->getRoles());
    // }else if($this->user->getRole()->getId() == 4 && $opt_eval_form == 0){
    //   $role = $this->em->getRepository(UsersRoles::class)->find(3);
    //   // $this->user->setRole($role);
    //   $objToken = new UsernamePasswordToken($this->user, null, 'main', $role);
    // }else{
    //   $objToken = new UsernamePasswordToken($this->user, null, 'main', $this->user->getRoles());
    // }


    var_dump($this->user->getRoles());
    die();
    // $objToken = new UsernamePasswordToken($this->user, null, 'main', $this->user->getRoles());

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

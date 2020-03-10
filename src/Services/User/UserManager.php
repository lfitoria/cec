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

    // if (!$this->checkUserExists($strEmail['cedula'], $strEmail['opt_eval_form'] == "0" ? $strEmail['role_login'] : null )) {
    if (!$this->checkUserExists($strEmail['cedula'], $strEmail['opt_eval_form'] == "0" ? $strEmail['role_login'] : null )) {
      // create new user
      $this->createUser($strEmail);      
    }else{
      // $objUser->setCarnet($strEmail["carnet"]);
      if ( isset($strEmail["carnet"]) ) {
        $this->user->setCarnet($strEmail["carnet"]);
        $this->user->setCedulaUsuario($strEmail["id"]);
      }
    }

    $this->createLoginSession($strEmail['opt_eval_form'],$strEmail['opt_eval_form'] == "0" ? $strEmail['role_login'] : null);
  }

  // get user data from database
  public function getUser($strEmail,$role_id) {
    $array_search = array('email' => $strEmail);
    
    // if($role_id){
      
    //   $role = $this->em->getRepository(UsersRoles::class)->find(intval($role_id));
      
    //   $array_search['role'] = $role;
    // } 
    
    // return $this->em->getRepository(LdapUser::class)->findOneBy(array('email' => $strEmail,'role' => $role));
    return $this->em->getRepository(LdapUser::class)->findOneBy($array_search);
  }
  public function getPass($strEmail) {
    return $this->em->getRepository(LdapUser::class)->findOneBy(array('email' => $strEmail));
  }

  // Check if a user exists on database
  public function checkUserExists($strEmail,$role_id) {
    $this->user = $this->getUser($strEmail,$role_id);
    
  
    return (!empty($this->user)) ? true : false;
  }

  // Create new user on database
  public function createUser($strEmail) {
    $boolResult = false;
    $objCurrentDatetime = new \Datetime();

    try {

      if (isset($strEmail["tipo_usuario_ldap"][1]) && $strEmail["tipo_usuario_ldap"][1] == "DOCENTE") {
        $role_find = 3;
      } else {
        $role_find = 2;
      }

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
  public function createLoginSession($opt_eval_form,$role_id) {
    $_SESSION["isResearcher"] = false;
    $role = $this->user->getRoles();
    // var_dump($role[0]);
    //   die();
    if(in_array($this->user->getRole()->getDescription(), ["ROLE_EVALUATOR", "ROLE_ADMIN"])   && $opt_eval_form === "0"){
      $role = ["ROLE_RESEARCHER"];
      $_SESSION["isResearcher"] = true;
      // var_dump("entra");
      // die();
    }

    if($role[0] !==  "ROLE_ADMIN" || $role[0] !==  "ROLE_EVALUATOR" ){
      if($role_id && $opt_eval_form === "0"){
      $role_s = $this->em->getRepository(UsersRoles::class)->find(intval($role_id));
      $this->user->setRole($role_s);
      }
    }
    
    $this->user->setLastLoginDate(new \Datetime());
    $this->em->persist($this->user);
    $this->em->flush();
    
  

    $objToken = new UsernamePasswordToken($this->user, null, 'main', $role);
    
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

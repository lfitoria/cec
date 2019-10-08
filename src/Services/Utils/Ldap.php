<?php

// src/Services/Utils/Ldap.php

namespace App\Services\Utils;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

class Ldap {

  private $em, $request, $container;
  private $strLdapServer, $strLdapDN;
  private $objLdapBind, $strLdapFilter, $strLdapDC, $objLdapConnection;
  private $arrLoginResult, $strUserEmail, $strUserPasswd;

  public function __construct(ContainerInterface $container, RequestStack $requestStack) {
    $this->requestStack = $requestStack;
    $this->container = $container;

    // LDAP CONFIG
    // $this->strLdapServer = "ldap2.ucr.ac.cr:636";
    $this->strLdapServer = "ldaps://ldap2.ucr.ac.cr:636";
    $this->strLdapDN = "DomainName";
    $this->strLdapDC = "dc=DcName,dc=local";
    $this->userLdap = "sigpro.vinv";
    $this->passLdap = "Rx2tn.2bm4";
    $this->port = 636;
    $this->dn = "uid=sigpro.vinv,ou=Special Users,dc=ucr,dc=ac,dc=cr";
    $this->dn2 = "cn=users,cn=accounts,dc=ucr,dc=ac,dc=cr";
    // init vars
    $this->objLdapBind = false;
    $this->objLdapConnection = false;
  }

  // Load LDAP config
  public function login() {

    $request = $this->requestStack->getCurrentRequest();
    $username = $request->request->get('email');
    $CLAVE_USUARIO = $request->request->get('password');

    $this->dn3 = "uid=" . $username . ",cn=users,cn=accounts,dc=ucr,dc=ac,dc=cr";

    $ldap['conn'] = $this->ldapConnect();
    // CONECTANDO COMO USUARIO CON PERMISO ESPECIAL
    $ldap['bind'] = ldap_bind($ldap['conn'], $this->dn, $this->passLdap);

    if (!$ldap['bind']) {
      echo ldap_error($ldap['conn']);
      die("Error de conexión.");
    }

    $ldap['result'] = $this->checkUserCredencials($ldap['conn'], $username);

    if ($ldap['result']) {
      try {
        $ldap['bind2'] = @ldap_bind($ldap['conn'], $this->dn3, $CLAVE_USUARIO);
        if (!$ldap['bind2']) {
          $this->arrLoginResult['ERROR'] = 'INVALID_CREDENTIALS';
        } else {   // USUARIO AUTENTICADO CORRECTAMENTE.				
          $justthese = array();
          // $justthese = array("ou", "uid", "givenname", "ucrcarne", "mail", "ucrnescuela", "ucrrelacion"); //the attributes to pull, which is much more efficient than pulling all attributes if you don't do this
          $ldap['result2'] = ldap_search($ldap['conn'], $this->dn2, 'uid=' . $username);
          $data = ldap_get_entries($ldap['conn'], $ldap['result']);

          $this->arrLoginResult['USERNAME'] = !empty($data[0]['mail'][0]) ? $data[0]['mail'][0] : NULL;

          $objUserServ = $this->container->get('user_manager');
          $objUserServ->loginAction(array(
              "cedula" => $data[0]["mail"][0],
              "id" => $data[0]["ucruserid"][0],
              "nombre" => $data[0]["cn"][0],
              "carnet" => $data[0]["ucrstudentid"][0],
              "tipo_usuario_ldap" => $data[0]["ucrrelacion"]
          ));
        }
      } catch (Exception $e) {
        ldap_close($ldap['conn']);
        return array();
      }
    } else {
      ldap_close($ldap['conn']);
      return array();
    }

    ldap_close($ldap['conn']);
    return json_encode($this->arrLoginResult);
  }

  private function ldapConnect() {
    ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
    putenv('LDAPTLS_CACERT=./lets-encrypt-x3-cross-signed.pem');

    $ldapConnection = ldap_connect($this->strLdapServer)
            or die("Hubo un problema con la conexión " . $this->strLdapServer);

    ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
    return $ldapConnection;
  }

  private function checkUserCredencials($conn, $username) {
    try {
      $ldapSearch = ldap_search($conn, $this->dn2, 'uid=' . $username);
    } catch (Exception $e) {
      $ldapSearch = false;
    }
    
    return $ldapSearch;
  }

}

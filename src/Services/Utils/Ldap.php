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
        $this->strLdapServer = "ldap2.ucr.ac.cr:636";
        $this->strLdapDN = "DomainName";
                $this->strLdapDC = "dc=DcName,dc=local";

        // init vars
        $this->objLdapBind = false;
        $this->objLdapConnection = false;
    }

    // Load LDAP config
    public function login() {
        
        $request = $this->requestStack->getCurrentRequest();
        $NOMBRE_USUARIO = $request->request->get('email');
        $CLAVE_USUARIO = $request->request->get('password');
        

        // USUARIO LDAP CON PERMISO ESPECIAL DE LECTURA - SE LO ASIGNA EL CENTRO DE INFORMÁTICA
        $ldap['user'] = "sigpro.vinv";
        $ldap['pass'] = "Rx2tn.2bm4";
     
        $ldap['host'] = 'ldaps://ldap2.ucr.ac.cr:636';
        $ldap['port'] = 636; //389 SI NO FUNCIONA EL 636;
        $ldap['dn'] = "uid=sigpro.vinv,ou=Special Users,dc=ucr,dc=ac,dc=cr";
     
        $ldap['dn2'] = "cn=users,cn=accounts,dc=ucr,dc=ac,dc=cr";
        $ldap['dn3'] = "uid=" . $NOMBRE_USUARIO . ",cn=users,cn=accounts,dc=ucr,dc=ac,dc=cr";
     
        ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
        putenv('LDAPTLS_CACERT=./lets-encrypt-x3-cross-signed.pem');

        // CONEXIÓN CON SERVIDOR LDAP
        $ldap['conn'] = ldap_connect($ldap['host'])
                or die("Hubo un problema con la conexión " . $ldap['host']);

        ldap_set_option($ldap['conn'], LDAP_OPT_PROTOCOL_VERSION, 3);
        
        // CONECTANDO COMO USUARIO CON PERMISO ESPECIAL
        $ldap['bind'] = ldap_bind($ldap['conn'], $ldap['dn'], $ldap['pass']);

        if (!$ldap['bind']) {
            echo ldap_error($ldap['conn']);
            die("Error de conexión.");
        }
        
        // SE BUSCA EL USUARIO A AUTENTICAR
        try {
            $ldap['result'] = ldap_search($ldap['conn'], $ldap['dn2'], 'uid=' . $NOMBRE_USUARIO);
        } catch (Exception $e) {
            $ldap['result'] = false;
        }
        
        if ($ldap['result']) {
            try {
                $ldap['bind2'] = @ldap_bind($ldap['conn'], $ldap['dn3'], $CLAVE_USUARIO);
                if (!$ldap['bind2']) {
                    $this->arrLoginResult['ERROR'] = 'INVALID_CREDENTIALS';
                } else {   // USUARIO AUTENTICADO CORRECTAMENTE.				
                    $justthese = array();
                    // $justthese = array("ou", "uid", "givenname", "ucrcarne", "mail", "ucrnescuela", "ucrrelacion"); //the attributes to pull, which is much more efficient than pulling all attributes if you don't do this
                    $ldap['result2'] = ldap_search($ldap['conn'], $ldap['dn2'], 'uid=' . $NOMBRE_USUARIO);
                    $data = ldap_get_entries($ldap['conn'], $ldap['result']);
                    
                    $this->arrLoginResult['USERNAME'] = ! empty($data[0]['mail'][0]) ? $data[0]['mail'][0] : NULL;
                    
                    $objUserServ = $this->container->get('user_manager');
                    $objUserServ->loginAction(array(
                        "cedula" => $data[0]["mail"][0],

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

}

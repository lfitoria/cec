<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\UsersRoles;
/**
 * LdapUser
 *
 * @ORM\Table(name="ldap_user")
 * @ORM\Entity
 */
class LdapUser implements UserInterface {
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     */
    private $email;
    
    private $isResearcher;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=200, nullable=false)
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=300, nullable=true)
     */
    private $password;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="external", type="boolean", nullable=true)
     */
    private $external;

    /**
     * @ORM\ManyToOne(targetEntity="UsersRoles", inversedBy="ldap_user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login_date", type="datetime", nullable=true)
     */
    private $lastLoginDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     */
    private $creationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deletion_date", type="datetime", nullable=true)
     */
    private $deletionDate;

     /**
     * @var string
     *
     * @ORM\Column(name="carnet", type="string", length=200, nullable=true)
     */
    private $carnet;

    /**
     * @var string
     *
     * @ORM\Column(name="cedula_usuario", type="string", length=200, nullable=true)
     */
    private $cedula_usuario;

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getRole() {
      $this->session = $_SESSION;
      if(isset($this->session['isResearcher'])){
        $role = new UsersRoles();
        $role->setId(3);
        $role->setDescription("ROLE_RESEARCHER");        
        return $role;

      }
      return $this->role;
    }

    // function getLastLoginDate(): \DateTime {
    //     return $this->lastLoginDate;
    // }

    // function getCreationDate(): \DateTime {
    //     return $this->creationDate;
    // }

    // function getDeletionDate(): \DateTime {
    //     return $this->deletionDate;
    // }
    function getLastLoginDate() {
        return $this->lastLoginDate;
    }

    function getCreationDate(){
        return $this->creationDate;
    }

    function getDeletionDate(){
        return $this->deletionDate;
    }

    function getCarnet() {
        return $this->carnet;
    }

    function setCarnet($carnet) {
        $this->carnet = $carnet;
    }
    function getName() {
        return $this->name;
    }
    
    function setName($name) {
        $this->name = $name;
    }

    public function getCedulaUsuario() {
        return $this->cedula_usuario;
    }
    function setExternal($external) {
        $this->external = $external;
    }

    function getExternal() {
        return $this->external;
    }
    
    public function setCedulaUsuario($cedula_usuario) {
        $this->cedula_usuario = $cedula_usuario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setRole($role) {
        
        $this->role = $role;
    }

    function setLastLoginDate(\DateTime $lastLoginDate) {
        $this->lastLoginDate = $lastLoginDate;
    }

    function setCreationDate(\DateTime $creationDate) {
        $this->creationDate = $creationDate;
    }

    function setDeletionDate(\DateTime $deletionDate) {
        $this->deletionDate = $deletionDate;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
    // public function getPassword() {
    //     return null;
    // }
    public function getPassword() {
        return $this->password;
    }

    function getIsResearcher() {
      return $this->isResearcher;
    }

    function setIsResearcher($isResearcher) {
      $this->isResearcher = $isResearcher;
    }

    public function getRoles() {
        return [
            $this->role->getDescription()
        ];
    }

    public function getSalt() {
        return '';
    }

    public function eraseCredentials() {
        
    }

    function setUsername($username) {
        $this->username = $username;
    }
    
}

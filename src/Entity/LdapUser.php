<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @ORM\Column(name="password", type="string", length=45, nullable=true)
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

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getRole() {
        return $this->role;
    }

    function getLastLoginDate(): \DateTime {
        return $this->lastLoginDate;
    }

    function getCreationDate(): \DateTime {
        return $this->creationDate;
    }

    function getDeletionDate(): \DateTime {
        return $this->deletionDate;
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

    public function getPassword() {
        return null;
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

}

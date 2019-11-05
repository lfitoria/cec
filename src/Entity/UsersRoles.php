<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users roles
 *
 * @ORM\Table(name="users_roles")
 * @ORM\Entity(repositoryClass="App\Repository\UsersRolesRepository")
 */
class UsersRoles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $label;
    
    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }
    public function __toString() {
        return $this->description;
    }
    function getLabel() {
        return $this->id;
    }

    function setLabel(): ?string {
        return $this->label;
    }
}

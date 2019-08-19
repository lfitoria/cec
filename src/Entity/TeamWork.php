<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamWorkRepository")
 */
class TeamWork {

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $name;

  /**
   * @ORM\Column(type="integer", nullable=true, name="student_id")
   */
  private $studentId;

  /**
   * @ORM\Column(type="string", length=255, nullable=true, name="student_email")
   */
  private $studentEmail;

  public function getId(): ?int {
    return $this->id;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setName(string $name): self {
    $this->name = $name;

    return $this;
  }
  function getStudentId() {
    return $this->studentId;
  }

  function getStudentEmail() {
    return $this->studentEmail;
  }

  function setStudentId($studentId) {
    $this->studentId = $studentId;
  }

  function setStudentEmail($studentEmail) {
    $this->studentEmail = $studentEmail;
  }



}

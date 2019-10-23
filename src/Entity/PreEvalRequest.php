<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Criterion;
use App\Entity\ProjectRequest;

/**
 * PreEvalRequest
 * 
 * @ORM\Table(name="pre_eval_request", indexes={@ORM\Index(name="FK_pre_eval_status", columns={"status"}), @ORM\Index(name="FK_pre_eval_user", columns={"user_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\PreEvalRequestRepository")
 */
class PreEvalRequest {

  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer", nullable=false)
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="IDENTITY")
   */
  private $id;

  /**
   * @var string|null
   *
   * @ORM\Column(name="observations", type="string", length=500, nullable=true)
   */
  private $observations;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime", nullable=false)
   */
  private $date;

  /**
   * @var bool
   *
   * @ORM\Column(name="current", type="boolean", nullable=false)
   */
  private $current;

  /**
   * @var \StatusRequest
   *
   * @ORM\ManyToOne(targetEntity="Criterion")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="status", referencedColumnName="id")
   * })
   */
  private $status;

  /**
   * @var \ProjectRequest
   *
   * @ORM\ManyToOne(targetEntity="ProjectRequest")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="request_id", referencedColumnName="id")
   * })
   */
  private $request;

  /**
   * @var \User
   *
   * @ORM\ManyToOne(targetEntity="User")
   * @ORM\JoinColumns({
   *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   * })
   */
  private $user;

  public function getId(): ?int {
    return $this->id;
  }

  public function getObservations(): ?string {
    return $this->observations;
  }

  public function setObservations(?string $observations): self {
    $this->observations = $observations;

    return $this;
  }

  public function getDate(): ?\DateTimeInterface {
    return $this->date;
  }

  public function setDate(\DateTimeInterface $date): self {
    $this->date = $date;

    return $this;
  }

  public function getCurrent(): ?bool {
    return $this->current;
  }

  public function setCurrent(bool $current): self {
    $this->current = $current;

    return $this;
  }

  public function getStatus(): ?Criterion {
    return $this->status;
  }

  public function setStatus(?Criterion $status): self {
    $this->status = $status;

    return $this;
  }

  public function getUser(): ?User {
    return $this->user;
  }

  public function setUser(?User $user): self {
    $this->user = $user;

    return $this;
  }
  
  public function getRequest(): ?ProjectRequest
    {
        return $this->request;
    }

    public function setRequest(?ProjectRequest $request): self
    {
        $this->request = $request;

        return $this;
    }
}

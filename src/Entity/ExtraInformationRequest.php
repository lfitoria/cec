<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExtraInformationRequest
 *
 * @ORM\Table(name="extra_information_request", indexes={@ORM\Index(name="FK_extra_information_request", columns={"request_id"})})
 * @ORM\Entity
 */
class ExtraInformationRequest
{
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
     * @ORM\Column(name="tutor_name", type="string", length=100, nullable=true)
     */
    private $tutorName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tutor_id", type="string", length=45, nullable=true)
     */
    private $tutorId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tutor_email", type="string", length=100, nullable=true)
     */
    private $tutorEmail;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="grupal_project", type="boolean", nullable=true)
     */
    private $grupalProject;

    /**
     * @var \ProjectRequest
     *
     * @ORM\ManyToOne(targetEntity="ProjectRequest")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="request_id", referencedColumnName="id")
     * })
     */
    private $request;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTutorName(): ?string
    {
        return $this->tutorName;
    }

    public function setTutorName(?string $tutorName): self
    {
        $this->tutorName = $tutorName;

        return $this;
    }

    public function getTutorId(): ?string
    {
        return $this->tutorId;
    }

    public function setTutorId(?string $tutorId): self
    {
        $this->tutorId = $tutorId;

        return $this;
    }

    public function getTutorEmail(): ?string
    {
        return $this->tutorEmail;
    }

    public function setTutorEmail(?string $tutorEmail): self
    {
        $this->tutorEmail = $tutorEmail;

        return $this;
    }

    public function getGrupalProject(): ?bool
    {
        return $this->grupalProject;
    }

    public function setGrupalProject(?bool $grupalProject): self
    {
        $this->grupalProject = $grupalProject;

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

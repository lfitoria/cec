<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * AcademicRequestInfo
 *
 * @ORM\Table(name="academic_request_info", indexes={@ORM\Index(name="FK_acad_req", columns={"request_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\AcademicRequestInfoRepository")
 */
class AcademicRequestInfo
{
    
    public function __construct() {
        $this->invType = new ArrayCollection();
    }

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
     * @ORM\Column(name="summary_observ", type="text", length=1500, nullable=true)
     */
    private $summaryObserv;

    /**
     * @var string|null
     *
     * @ORM\Column(name="objetives", type="text", length=1500, nullable=true)
     */
    private $objetives;

    /**
     * @var string|null
     *
     * @ORM\Column(name="questions", type="text", length=1500, nullable=true)
     */
    private $questions;

    /**
     * @var string|null
     *
     * @ORM\Column(name="hypothesis", type="text", length=1500, nullable=true)
     */
    private $hypothesis;

    /**
     * @var string|null
     *
     * @ORM\Column(name="metodology_observ", type="text", length=2000, nullable=true)
     */
    private $metodologyObserv;

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
     * @ORM\ManyToMany(targetEntity="Criterion")
     * @ORM\JoinTable(name="inv_type_ethic_eval_request")
     */
    private $invType;
    
    
    function getInvType(): Collection {
        return $this->invType;
    }

    function setInvType(Doctrine\Common\Collections\Collection $invType) {
        $this->invType = $invType;
    }
    
    public function addInvType(Criterion $invType): self {
        if (!$this->invType->contains($invType)) {
            $this->invType[] = $invType;
        }

        return $this;
    }

    public function removeInvType(Criterion $invType): self {
        if ($this->invType->contains($invType)) {
            $this->invType->removeElement($invType);
        }

        return $this;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSummaryObserv(): ?string
    {
        return $this->summaryObserv;
    }

    public function setSummaryObserv(?string $summaryObserv): self
    {
        $this->summaryObserv = $summaryObserv;

        return $this;
    }

    public function getObjetives(): ?string
    {
        return $this->objetives;
    }

    public function setObjetives(?string $objetives): self
    {
        $this->objetives = $objetives;

        return $this;
    }

    public function getQuestions(): ?string
    {
        return $this->questions;
    }

    public function setQuestions(?string $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    public function getHypothesis(): ?string
    {
        return $this->hypothesis;
    }

    public function setHypothesis(?string $hypothesis): self
    {
        $this->hypothesis = $hypothesis;

        return $this;
    }

    public function getMetodologyObserv(): ?string
    {
        return $this->metodologyObserv;
    }

    public function setMetodologyObserv(?string $metodologyObserv): self
    {
        $this->metodologyObserv = $metodologyObserv;

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

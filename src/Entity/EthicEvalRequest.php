<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EthicEvalRequest
 *
 * @ORM\Table(name="ethic_eval_request", indexes={@ORM\Index(name="FK_ethic_req", columns={"request_id"})})
 * @ORM\Entity
 */
class EthicEvalRequest
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
     * @ORM\Column(name="amount_participants", type="string", length=1000, nullable=true)
     */
    private $amountParticipants;

    /**
     * @var string|null
     *
     * @ORM\Column(name="in_ex_criteria", type="string", length=1500, nullable=true)
     */
    private $inExCriteria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="recruitment_participants", type="string", length=1500, nullable=true)
     */
    private $recruitmentParticipants;

    /**
     * @var string|null
     *
     * @ORM\Column(name="collection_information", type="string", length=1500, nullable=true)
     */
    private $collectionInformation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="risk_declaration", type="string", length=1000, nullable=true)
     */
    private $riskDeclaration;

    /**
     * @var string|null
     *
     * @ORM\Column(name="benefits_for_participant", type="string", length=500, nullable=true)
     */
    private $benefitsForParticipant;

    /**
     * @var string|null
     *
     * @ORM\Column(name="benefits_for_population", type="string", length=500, nullable=true)
     */
    private $benefitsForPopulation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="previsions_privacy", type="string", length=500, nullable=true)
     */
    private $previsionsPrivacy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="future_use", type="string", length=500, nullable=true)
     */
    private $futureUse;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="informed_consent", type="boolean", nullable=true)
     */
    private $informedConsent;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="informed_assent", type="boolean", nullable=true)
     */
    private $informedAssent;

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

    public function getAmountParticipants(): ?string
    {
        return $this->amountParticipants;
    }

    public function setAmountParticipants(?string $amountParticipants): self
    {
        $this->amountParticipants = $amountParticipants;

        return $this;
    }

    public function getInExCriteria(): ?string
    {
        return $this->inExCriteria;
    }

    public function setInExCriteria(?string $inExCriteria): self
    {
        $this->inExCriteria = $inExCriteria;

        return $this;
    }

    public function getRecruitmentParticipants(): ?string
    {
        return $this->recruitmentParticipants;
    }

    public function setRecruitmentParticipants(?string $recruitmentParticipants): self
    {
        $this->recruitmentParticipants = $recruitmentParticipants;

        return $this;
    }

    public function getCollectionInformation(): ?string
    {
        return $this->collectionInformation;
    }

    public function setCollectionInformation(?string $collectionInformation): self
    {
        $this->collectionInformation = $collectionInformation;

        return $this;
    }

    public function getRiskDeclaration(): ?string
    {
        return $this->riskDeclaration;
    }

    public function setRiskDeclaration(?string $riskDeclaration): self
    {
        $this->riskDeclaration = $riskDeclaration;

        return $this;
    }

    public function getBenefitsForParticipant(): ?string
    {
        return $this->benefitsForParticipant;
    }

    public function setBenefitsForParticipant(?string $benefitsForParticipant): self
    {
        $this->benefitsForParticipant = $benefitsForParticipant;

        return $this;
    }

    public function getBenefitsForPopulation(): ?string
    {
        return $this->benefitsForPopulation;
    }

    public function setBenefitsForPopulation(?string $benefitsForPopulation): self
    {
        $this->benefitsForPopulation = $benefitsForPopulation;

        return $this;
    }

    public function getPrevisionsPrivacy(): ?string
    {
        return $this->previsionsPrivacy;
    }

    public function setPrevisionsPrivacy(?string $previsionsPrivacy): self
    {
        $this->previsionsPrivacy = $previsionsPrivacy;

        return $this;
    }

    public function getFutureUse(): ?string
    {
        return $this->futureUse;
    }

    public function setFutureUse(?string $futureUse): self
    {
        $this->futureUse = $futureUse;

        return $this;
    }

    public function getInformedConsent(): ?bool
    {
        return $this->informedConsent;
    }

    public function setInformedConsent(?bool $informedConsent): self
    {
        $this->informedConsent = $informedConsent;

        return $this;
    }

    public function getInformedAssent(): ?bool
    {
        return $this->informedAssent;
    }

    public function setInformedAssent(?bool $informedAssent): self
    {
        $this->informedAssent = $informedAssent;

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

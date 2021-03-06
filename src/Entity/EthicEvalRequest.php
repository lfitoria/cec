<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * EthicEvalRequest
 *
 * @ORM\Table(name="ethic_eval_request", indexes={@ORM\Index(name="FK_ethic_req", columns={"request_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\EthicEvalRequestRepository")
 */
class EthicEvalRequest {

  function __construct() {
    $this->population = new ArrayCollection();
    $this->dataType = new ArrayCollection();
    $this->ethicEvalFiles = new ArrayCollection();
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
   * @ORM\Column(name="amount_participants", type="text", length=3000, nullable=true)
   */
  private $amountParticipants;

  /**
   * @var string|null
   *
   * @ORM\Column(name="in_ex_criteria", type="text", length=2000, nullable=true)
   */
  private $inExCriteria;

  /**
   * @var string|null
   *
   * @ORM\Column(name="ex_criteria", type="text", length=2000, nullable=true)
   */
  private $exCriteria;

  /**
   * @var string|null
   *
   * @ORM\Column(name="recruitment_participants", type="text", length=2000, nullable=true)
   */
  private $recruitmentParticipants;

  /**
   * @var string|null
   *
   * @ORM\Column(name="collection_information", type="text", length=5000, nullable=true)
   */
  private $collectionInformation;

  /**
   * @var string|null
   *
   * @ORM\Column(name="risk_declaration", type="text", length=2000, nullable=true)
   */
  private $riskDeclaration;

  /**
   * @var string|null
   *
   * @ORM\Column(name="benefits_for_participant", type="text", length=1500, nullable=true)
   */
  private $benefitsForParticipant;

  /**
   * @var string|null
   *
   * @ORM\Column(name="benefits_for_population", type="text", length=1500, nullable=true)
   */
  private $benefitsForPopulation;

  /**
   * @var string|null
   *
   * @ORM\Column(name="previsions_privacy", type="text", length=1000, nullable=true)
   */
  private $previsionsPrivacy;

  /**
   * @var string|null
   *
   * @ORM\Column(name="future_use", type="text", length=1000, nullable=true)
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
   * @var bool|null
   *
   * @ORM\Column(name="aditional_files", type="boolean", nullable=true)
   */
  private $aditionalFiles;

  /**
   * @ORM\ManyToMany(targetEntity="Criterion")
   * @ORM\JoinTable(name="population_ethic_eval_request")
   */
  private $population;

  /**
   * @ORM\ManyToMany(targetEntity="Criterion")
   * @ORM\JoinTable(name="data_type_ethic_eval_request")
   */
  private $dataType;

  /**
   * @ORM\ManyToMany(targetEntity="File")
   * @ORM\JoinTable(name="files_ethic_eval")
   */
  private $ethicEvalFiles;

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
   * @var string|null
   *
   * @ORM\Column(name="devolution_result_show", type="text", length=1500, nullable=true)
   */
  private $devolutionResultShow;

  function getEthicEvalFiles() {
    return $this->ethicEvalFiles;
  }

  function setEthicEvalFiles($ethicEvalFiles) {
    $this->ethicEvalFiles = $ethicEvalFiles;
  }

  public function addEthicEvalFiles($files): self {
    foreach ($files as &$file) {
      if (!$this->ethicEvalFiles->contains($file)) {
        $this->ethicEvalFiles[] = $file;
      }
    }


    return $this;
  }

  function getDataType(): Collection {
    return $this->dataType;
  }

  function setDataType(Doctrine\Common\Collections\Collection $dataType) {
    $this->dataType = $dataType;
  }

  function getPopulation(): Collection {
    return $this->population;
  }

  function setPopulation(Doctrine\Common\Collections\Collection $population) {
    $this->population = $population;
  }

  public function getId(): ?int {
    return $this->id;
  }

  public function getAmountParticipants(): ?string {
    return $this->amountParticipants;
  }

  public function setAmountParticipants(?string $amountParticipants): self {
    $this->amountParticipants = $amountParticipants;

    return $this;
  }

  public function getInExCriteria(): ?string {
    return $this->inExCriteria;
  }

  public function setInExCriteria(?string $inExCriteria): self {
    $this->inExCriteria = $inExCriteria;

    return $this;
  }
  
  public function getExCriteria(): ?string {
    return $this->exCriteria;
  }

  public function setExCriteria(?string $exCriteria): self {
    $this->exCriteria = $exCriteria;

    return $this;
  }
  
  public function getDevolutionResultShow(): ?string {
    return $this->devolutionResultShow;
  }

  public function setDevolutionResultShow(?string $devolutionResultShow): self {
    $this->devolutionResultShow = $devolutionResultShow;

    return $this;
  }

  public function getRecruitmentParticipants(): ?string {
    return $this->recruitmentParticipants;
  }

  public function setRecruitmentParticipants(?string $recruitmentParticipants): self {
    $this->recruitmentParticipants = $recruitmentParticipants;

    return $this;
  }

  public function getCollectionInformation(): ?string {
    return $this->collectionInformation;
  }

  public function setCollectionInformation(?string $collectionInformation): self {
    $this->collectionInformation = $collectionInformation;

    return $this;
  }

  public function getRiskDeclaration(): ?string {
    return $this->riskDeclaration;
  }

  public function setRiskDeclaration(?string $riskDeclaration): self {
    $this->riskDeclaration = $riskDeclaration;

    return $this;
  }

  public function getBenefitsForParticipant(): ?string {
    return $this->benefitsForParticipant;
  }

  public function setBenefitsForParticipant(?string $benefitsForParticipant): self {
    $this->benefitsForParticipant = $benefitsForParticipant;

    return $this;
  }

  public function getBenefitsForPopulation(): ?string {
    return $this->benefitsForPopulation;
  }

  public function setBenefitsForPopulation(?string $benefitsForPopulation): self {
    $this->benefitsForPopulation = $benefitsForPopulation;

    return $this;
  }

  public function getPrevisionsPrivacy(): ?string {
    return $this->previsionsPrivacy;
  }

  public function setPrevisionsPrivacy(?string $previsionsPrivacy): self {
    $this->previsionsPrivacy = $previsionsPrivacy;

    return $this;
  }

  public function getFutureUse(): ?string {
    return $this->futureUse;
  }

  public function setFutureUse(?string $futureUse): self {
    $this->futureUse = $futureUse;

    return $this;
  }

  public function getInformedConsent(): ?bool {
    return $this->informedConsent;
  }

  public function setInformedConsent(?bool $informedConsent): self {
    $this->informedConsent = $informedConsent;

    return $this;
  }

  public function getInformedAssent(): ?bool {
    return $this->informedAssent;
  }

  public function setInformedAssent(?bool $informedAssent): self {
    $this->informedAssent = $informedAssent;

    return $this;
  }

  //
  public function getAditionalFiles(): ?bool {
    return $this->aditionalFiles;
  }

  public function setAditionalFiles(?bool $aditionalFiles): self {
    $this->aditionalFiles = $aditionalFiles;

    return $this;
  }

  public function getRequest(): ?ProjectRequest {
    return $this->request;
  }

  public function setRequest(?ProjectRequest $request): self {
    $this->request = $request;

    return $this;
  }

  public function addPopulation(Criterion $population): self {
    if (!$this->population->contains($population)) {
      $this->population[] = $population;
    }

    return $this;
  }

  public function removePopulation(Criterion $population): self {
    if ($this->population->contains($population)) {
      $this->population->removeElement($population);
    }

    return $this;
  }

  public function addDataType(Criterion $dataType): self {
    if (!$this->dataType->contains($dataType)) {
      $this->dataType[] = $dataType;
    }

    return $this;
  }

  public function removeDataType(Criterion $dataType): self {
    if ($this->dataType->contains($dataType)) {
      $this->dataType->removeElement($dataType);
    }

    return $this;
  }

}

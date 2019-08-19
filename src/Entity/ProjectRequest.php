<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * ProjectRequest
 *
 * @ORM\Table(name="project_request")
 * @ORM\Entity
 */
class ProjectRequest {

  function __construct() {
    $this->users = new ArrayCollection();
    $this->infoRequestFiles = new ArrayCollection();
    $this->teamWork = new ArrayCollection();
    $this->teamWork = new ArrayCollection();
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
   * @var string
   *
   * @ORM\Column(name="title", type="string", length=400, nullable=false)
   */
  private $title;

  /**
   * @var string|null
   *
   * @ORM\Column(name="code", type="string", length=10, nullable=true)
   */
  private $code;

  /**
   * @var int|null
   *
   * @ORM\Column(name="state", type="integer", nullable=true)
   */
  private $state;

  /**
   * @var string|null
   *
   * @ORM\Column(name="ext_institutions", type="string", length=200, nullable=true)
   */
  private $extInstitutions;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="ext_institutions_authorization", type="boolean", nullable=true)
   */
  private $extInstitutionsAuthorization;

  /**
   * @var string|null
   *
   * @ORM\Column(name="place_of_study", type="string", length=200, nullable=true)
   */
  private $placeOfStudy;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="involves_humans", type="boolean", nullable=true)
   */
  private $involvesHumans;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="doc_human_information", type="boolean", nullable=true)
   */
  private $docHumanInformation;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="minute_commission_tfg", type="boolean", nullable=true)
   */
  private $minuteCommissionTFG;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="minute_final_work", type="boolean", nullable=true)
   */
  private $minuteFinalWork;

  /**
   * @var bool|null
   *
   * @ORM\Column(name="minute_research_center", type="boolean", nullable=true)
   */
  private $minutesResearchCenter;

  /**
   * @ORM\ManyToMany(targetEntity="File")
   * @ORM\JoinTable(name="files_info_request")
   */
  private $infoRequestFiles;

  /**
   * @ORM\ManyToMany(targetEntity="TeamWork", cascade={"persist"})
   * @ORM\JoinTable(name="team_works_project")
   */
  private $teamWork;

  /**
   * @var string|null
   *
   * @ORM\Column(name="project_unit", type="string", length=45, nullable=true)
   */
  private $projectUnit;

  /**
   * @ORM\ManyToMany(targetEntity="User")
   * @ORM\JoinTable(name="assignments_request")
   */
  private $users;

  /**
   * @var string
   *
   * @ORM\Column(name="grupalProject", type="boolean", nullable=true)
   */
  private $grupalProject;

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
   * @var string
   *
   * @ORM\Column(name="ascriptionUnit", type="string", length=400, nullable=false)
   */
  private $ascriptionUnit;

  /**
   * @var string
   *
   * @ORM\Column(name="ucrInstitutions", type="string", length=400, nullable=false)
   */
  private $ucrInstitutions;

  function getMinutesResearchCenter() {
    return $this->minutesResearchCenter;
  }
  
  function setMinutesResearchCenter($minutesResearchCenter) {
    $this->minutesResearchCenter = $minutesResearchCenter;
  }

  function setMinuteCommissionTFG($minuteCommissionTFG) {
    $this->minuteCommissionTFG = $minuteCommissionTFG;
  }
  
   function getMinuteCommissionTFG() {
    return $this->minuteCommissionTFG;
  }

  function getMinuteFinalWork() {
    return $this->minuteFinalWork;
  }

  function setMinuteFinalWork($minuteFinalWork) {
    $this->minuteFinalWork = $minuteFinalWork;
  }

  function getId() {
    return $this->id;
  }

  function getTitle() {
    return $this->title;
  }

  function getCode() {
    return $this->code;
  }

  function getState() {
    return $this->state;
  }

  function getExtInstitutions() {
    return $this->extInstitutions;
  }

  function getExtInstitutionsAuthorization() {
    return $this->extInstitutionsAuthorization;
  }

  function getPlaceOfStudy() {
    return $this->placeOfStudy;
  }

  function getInvolvesHumans() {
    return $this->involvesHumans;
  }

  function getDocHumanInformation() {
    return $this->docHumanInformation;
  }

  function getProjectUnit() {
    return $this->projectUnit;
  }

  public function getUsers(): Collection {
    return $this->users;
  }

  function setId($id) {
    $this->id = $id;
  }

  function setTitle($title) {
    $this->title = $title;
  }

  function setCode($code) {
    $this->code = $code;
  }

  function setState($state) {
    $this->state = $state;
  }

  function setExtInstitutions($extInstitutions) {
    $this->extInstitutions = $extInstitutions;
  }

  function setExtInstitutionsAuthorization($extInstitutionsAuthorization) {
    $this->extInstitutionsAuthorization = $extInstitutionsAuthorization;
  }

  function setPlaceOfStudy($placeOfStudy) {
    $this->placeOfStudy = $placeOfStudy;
  }

  function setInvolvesHumans($involvesHumans) {
    $this->involvesHumans = $involvesHumans;
  }

  function setDocHumanInformation($docHumanInformation) {
    $this->docHumanInformation = $docHumanInformation;
  }

  function setProjectUnit($projectUnit) {
    $this->projectUnit = $projectUnit;
  }

  public function setUsers($users) {
    $this->users = $users;

    return this;
  }

  public function addUser(User $user): self {
    if (!$this->users->contains($user)) {
      $this->users[] = $user;
    }

    return $this;
  }

  public function removeUser(User $user): self {
    if ($this->users->contains($user)) {
      $this->users->removeElement($user);
    }

    return $this;
  }
  
  function getInfoRequestFiles() {
    return $this->infoRequestFiles;
  }

  function setInfoRequestFiles($infoRequestFiles) {
    $this->infoRequestFiles = $infoRequestFiles;
  }

    
  public function addInfoRequestFiles($files): self {
    foreach ($files as &$file) {
      if (!$this->infoRequestFiles->contains($file)) {
        $this->infoRequestFiles[] = $file;
      }
    }


    return $this;
  }

  function getGrupalProject() {
    return $this->grupalProject;
  }

  function getAscriptionUnit() {
    return $this->ascriptionUnit;
  }

  function getUcrInstitutions() {
    return $this->ucrInstitutions;
  }

  function setGrupalProject($grupalProject) {
    $this->grupalProject = $grupalProject;
  }

  function setAscriptionUnit($ascriptionUnit) {
    $this->ascriptionUnit = $ascriptionUnit;
  }

  function setUcrInstitutions($ucrInstitutions) {
    $this->ucrInstitutions = $ucrInstitutions;
  }

  public function getTutorName(): ?string {
    return $this->tutorName;
  }

  public function setTutorName(?string $tutorName): self {
    $this->tutorName = $tutorName;

    return $this;
  }

  public function getTutorId(): ?string {
    return $this->tutorId;
  }

  public function setTutorId(?string $tutorId): self {
    $this->tutorId = $tutorId;

    return $this;
  }

  public function getTutorEmail(): ?string {
    return $this->tutorEmail;
  }

  public function setTutorEmail(?string $tutorEmail): self {
    $this->tutorEmail = $tutorEmail;

    return $this;
  }

  function getTeamWork() {
    return $this->teamWork;
  }

  function setTeamWork($teamWork) {
    $this->teamWork = $teamWork;
  }

}

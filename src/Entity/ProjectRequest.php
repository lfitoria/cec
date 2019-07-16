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
     * @ORM\ManyToMany(targetEntity="File")
     * @ORM\JoinTable(name="inst_auth_files_project")
     */
    private $extInstitutionsAuthorizationFiles;
    
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
     * @ORM\ManyToMany(targetEntity="File")
     * @ORM\JoinTable(name="human_info_files_project")
     */
    private $docHumanInformationFiles;
    
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
    
    
    function getExtInstitutionsAuthorizationFiles() {
        return $this->extInstitutionsAuthorizationFiles;
    }

    function getDocHumanInformationFiles() {
        return $this->docHumanInformationFiles;
    }

    function setExtInstitutionsAuthorizationFiles($extInstitutionsAuthorizationFiles) {
        $this->extInstitutionsAuthorizationFiles = $extInstitutionsAuthorizationFiles;
    }

    function setDocHumanInformationFiles($docHumanInformationFiles) {
        $this->docHumanInformationFiles = $docHumanInformationFiles;
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

}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use \DateTime;
/**
 * EvalRequest
 *
 * @ORM\Table(name="eval_request", indexes={@ORM\Index(name="FK_eval_status", columns={"status"}), @ORM\Index(name="FK_eval_user", columns={"user_id"})})
 * @ORM\Entity
 */
class EvalRequest
{
    function __construct() {
        $this->files = new ArrayCollection();
        $this->date = new DateTime();
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
     * @var int|null
     *
     * @ORM\Column(name="category", type="integer", nullable=true)
     */
    private $category;

    /**
     * @var string|null
     *
     * @ORM\Column(name="observations", type="string", length=1000, nullable=true)
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
     * @ORM\ManyToOne(targetEntity="StatusRequest")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="status", referencedColumnName="id")
     * })
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="eval_request")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToMany(targetEntity="File")
     * @ORM\JoinTable(name="files_eval")
     */
    private $files;
    
    function getId() {
        return $this->id;
    }

    function getCategory() {
        return $this->category;
    }

    function getObservations() {
        return $this->observations;
    }

    function getDate(): \DateTime {
        return $this->date;
    }

    function getCurrent() {
        return $this->current;
    }

    function getStatus() {
        return $this->status;
    }

    function getUser(): ?User
    {
        return $this->user;
    }

    public function getFiles(): Collection
    {
        return $this->files;
    }
    
    public function setFiles($files)
    {
        $this->files = $files;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setObservations($observations) {
        $this->observations = $observations;
    }

    function setDate(\DateTime $date) {
        $this->date = $date;
    }

    function setCurrent($current) {
        $this->current = $current;
    }

    function setStatus(\StatusRequest $status) {
        $this->status = $status;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
        }

        return $this;
    }
    
    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
        }

        return $this;
    }




}

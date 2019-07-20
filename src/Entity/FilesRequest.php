<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilesRequest
 *
 * @ORM\Table(name="files_request", indexes={@ORM\Index(name="FK_file_request_file", columns={"file_id"}), @ORM\Index(name="FK_file_request_request", columns={"request_id"})})
 * @ORM\Entity
 */
class FilesRequest
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
     * @ORM\Column(name="question_code", type="string", length=50, nullable=true)
     */
    private $questionCode;

    /**
     * @var \File
     *
     * @ORM\ManyToOne(targetEntity="File")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     * })
     */
    private $file;

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

    public function getQuestionCode(): ?string
    {
        return $this->questionCode;
    }

    public function setQuestionCode(?string $questionCode): self
    {
        $this->questionCode = $questionCode;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

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

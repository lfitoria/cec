<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 */
class File {

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
   * @ORM\Column(name="filename", type="string", length=200, nullable=false)
   */
  private $filename;

  /**
   * @var string
   *
   * @ORM\Column(name="original_name", type="string", length=200, nullable=false)
   */
  private $originalName;

  /**
   * @var string
   *
   * @ORM\Column(name="mime", type="string", length=50, nullable=false)
   */
  private $mime;

  /**
   * @var string
   *
   * @ORM\Column(name="size", type="string", length=50, nullable=false)
   */
  private $size;
  
  
  /**
   * @var string
   *
   * @ORM\Column(name="question_code", type="string", length=200, nullable=false)
   */
  private $questionCode;

  function getQuestionCode() {
    return $this->questionCode;
  }

  function setQuestionCode($questionCode) {
    $this->questionCode = $questionCode;
  }

  
  function getId() {
    return $this->id;
  }

  function getFilename() {
    return $this->filename;
  }

  function getMime() {
    return $this->mime;
  }

  function getSize() {
    return $this->size;
  }

  function setId($id) {
    $this->id = $id;
  }

  function getOriginalName() {
    return $this->originalName;
  }

  function setOriginalName($originalName) {
    $this->originalName = $originalName;
  }

  function setFilename($filename) {
    $this->filename = $filename;
  }

  function setMime($mime) {
    $this->mime = $mime;
  }

  function setSize($size) {
    $this->size = $size;
  }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="file")
 * @ORM\Entity
 */
class File
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
    private $original_name;

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
        return $this->original_name;
    }

    function setOriginalName($original_name) {
        $this->original_name = $original_name;
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

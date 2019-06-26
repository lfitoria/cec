<?php

namespace App\Services\Utils;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    private $targetDirectory;

    public function __construct() {
        
    }

    public function upload(UploadedFile $file, $targetDirectory) {
        $this->targetDirectory = $targetDirectory;
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        
        $newFile = new \App\Entity\File();
        
        $newFile->setFilename($fileName);
        $newFile->setOriginalName($file->getClientOriginalName());
        $newFile->setMime($file->getClientMimeType());
        $newFile->setSize($file->getClientSize());
        
        try {
            $file->move($targetDirectory, $fileName);
        } catch (FileException $e) {
            var_dump('MAL');
        }

        return $newFile;
    }

    public function getTargetDirectory() {
        return $this->targetDirectory;
    }

}

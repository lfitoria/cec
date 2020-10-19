<?php

namespace App\Services\Utils;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\File;

class FileManager {

  private $em;

  public function __construct(EntityManagerInterface $em) {
    $this->em = $em;
  }

  public function upload(UploadedFile $file, $targetDirectory, $questionCode, $description ) {
    // var_dump($description);
    // die();

    $fileName = md5(uniqid()) . '.' . $file->guessExtension();

    $newFile = new \App\Entity\File();

    $newFile->setFilename($fileName);
    $newFile->setOriginalName($file->getClientOriginalName());
    $newFile->setMime($file->getClientMimeType());
    $newFile->setSize($file->getSize());
    $newFile->setQuestionCode($questionCode);
    $newFile->setFiledescription($description);

    try {
      $file->move($targetDirectory, $fileName);
      $this->em->persist($newFile);

      return $newFile;
    } catch (FileException $e) {

      return false;
    }
  }

  public function uploadFiles($files, $targetDirectory, $questionCode, $descriptions = null) {
    // var_dump($files);
    // die();
    $uploadedFiles = array();

    // foreach($array as $key=>$value) {
    if ($files) {
      foreach ($files as $key=>$file) {
        
        var_dump($file);
        var_dump($targetDirectory);
        var_dump($questionCode);
        var_dump($descriptions);
        // var_dump($key);
        // die;
        $newFile = $this->upload($file, $targetDirectory, $questionCode, $descriptions[$key]);
        if ($newFile) {
          $uploadedFiles[] = $newFile;
        }
      }
    }

    return $uploadedFiles;
  }

  public function deleteFile(File $file, $targetDirectory) {
    $filePath = $targetDirectory . $file->getFilename();
    $wasDeleted = false;
  
    if (file_exists($filePath)) {
      unlink($filePath);

      $this->em->remove($file);
      $this->em->flush();

      $wasDeleted = true;
    }

    return $wasDeleted;
  }

  private function fileExists(File $file, $targetDirectory) {
    $filePath = $targetDirectory . $file->getFilename();
    return (file_exists($filePath));
  }

}

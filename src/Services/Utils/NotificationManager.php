<?php

namespace App\Services\Utils;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Utils\FileManager;

class NotificationManager {

  private $em;
  private $fileManager;
  private $transport;
  private $mailer;

  public function __construct(EntityManagerInterface $em, FileManager $fileManager) {
    $this->em = $em;
    $this->fileManager = $fileManager;

    // Create the Transport
    $this->transport = (new \Swift_SmtpTransport('smtp.ucr.ac.cr', 465, 'ssl'))
            ->setUsername('catedrahumboldt.vi@ucr.ac.cr')
            ->setPassword('$Humbo_2019#');

    $this->mailer = (new \Swift_Mailer($this->transport));
  }

  private function validateEmails($emails) {
    foreach ($emails as $email) {
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format: " . $email);
      }
    }
  }

  private function configureEmail($emailData) {
    $message = (new \Swift_Message())
            ->setSubject($emailData["subject"] ?? 'No subject')
            ->setFrom($emailData["from"])
            ->setContentType($emailData["contentType"] ?? 'text/html')
            ->setTo($emailData["to"])
            ->addCc($emailData["cc"])
            ->setBody($emailData["body"] ?? 'No body');

    if (isset($emailData["bcc"])) {
      $message->setBcc($emailData["bcc"]);
    }
    if (isset($emailData["attatchments"])) {
      $this->attatchFiles($emailData["attatchments"], $message);
    }

    return $message;
  }

  private function attatchFiles($attatchments, $message) {
    $fileDir = $this->getParameter('email_attatchments_directory');
    $files = $this->fileManager->uploadFiles($attatchments, $fileDir);

    foreach ($files as $file) {
      $target_path = $fileDir . "\\" . $file->getFilename();
      $message->attach(Swift_Attachment::fromPath($target_path));
    }
    $this->em->flush();
  }

  public function sendEmail($emailData) {

    //$this->validateEmails([$emailData["from"], $emailData["to"], $emailData["cc"]]);
    $message = $this->configureEmail($emailData);

    try {
      return $this->mailer->send($message);
    } catch (Exception $ex) {
      throw new Exception("There was an error while the email was sended");
    }
  }

  public function getTemplate($bodyData, $emailCode) {
    return "";
  }

}

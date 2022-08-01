<?php

namespace App\Services\Utils;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\Utils\FileManager;
use Exception;

class NotificationManager
{

  private $em;
  private $fileManager;
  private $transport;
  private $mailer;

  public function __construct(EntityManagerInterface $em, FileManager $fileManager)
  {
    $this->em = $em;
    $this->fileManager = $fileManager;

    // Create the Transport
    // CECUCR.20
    // $this->transport = (new \Swift_SmtpTransport('smtp.ucr.ac.cr', 465, 'ssl'))
    //         ->setUsername('catedrahumboldt.vi@ucr.ac.cr')
    //         ->setPassword('$Humbo_2019#');
    // $this->transport = (new \Swift_SmtpTransport('smtp.ucr.ac.cr', 465, 'ssl'))
    //          ->setUsername('cec@ucr.ac.cr')
    //          ->setPassword('CECUCR.16');
    // $this->transport = (new \Swift_SmtpTransport('smtp.ucr.ac.cr', 465, 'ssl'))
    //         ->setUsername('jonathan.rojas@ucr.ac.cr')
    //         ->setPassword('Gxs1607V***');
    $this->transport = (new \Swift_SmtpTransport('smtp.ucr.ac.cr', 465, 'ssl'))
      ->setUsername('cec@ucr.ac.cr')
      ->setPassword('$CEC_UCR_2021');

    $this->mailer = (new \Swift_Mailer($this->transport));
  }

  private function validateEmails($emails)
  {

    foreach ($emails as $email) {
      // var_dump($email);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Invalid email format: " . $email);
      }
    }
  }

  private function configureEmail($emailData)
  {
    $message = (new \Swift_Message())
      ->setSubject($emailData["subject"] ?? 'No subject')
      ->setFrom($emailData["from"])
      ->setContentType($emailData["contentType"] ?? 'text/html')
      ->setTo($emailData["to"])
      // ->addCc( ($emailData["cc"]?$emailData["cc"]:null ) )
      ->setBody($emailData["body"] ?? 'No body');

    if (isset($emailData["bcc"])) {
      $message->setBcc($emailData["bcc"]);
    }

    $ccEmails = is_array($emailData["cc"]) ? array_unique($emailData["cc"]) : $emailData["cc"] ;
    $ccEmailsCheckArray = is_array($ccEmails) ? array_filter($ccEmails) : $ccEmails ;

    // echo "<pre>";
    // echo "test email";
    // echo "---------1<br>";
    // var_dump($emailData["cc"]);
    // echo "---------2<br>";
    
    // var_dump($ccEmails);
    // echo "---------3<br>";
    // var_dump(is_array($ccEmails));
    
    // echo "---------4<br>";
    
    // var_dump($ccEmailsCheckArray);
    // echo "---------5<br>";
    // var_dump(empty($ccEmailsCheckArray));
    // echo "---------6<br>";
    // var_dump(!isset($ccEmailsCheckArray));
    // var_dump($emailData["to"]);
    // var_dump($emailData["attatchments"]);
    // echo "</pre>";
    // die();
    if (!isset($ccEmails)) {

      $message->setCc($ccEmails);
    }
    if (isset($emailData["attatchments"])) {
      $this->attatchFiles($emailData["attatchments"], $message);
    }

    return $message;
  }

  private function attatchFiles($attatchments, $message)
  {
    $fileDir = $this->getParameter('email_attatchments_directory');
    $files = $this->fileManager->uploadFiles($attatchments, $fileDir);

    foreach ($files as $file) {
      $target_path = $fileDir . "\\" . $file->getFilename();
      $message->attach(Swift_Attachment::fromPath($target_path));
    }
    $this->em->flush();
  }

  public function sendEmail($emailData)
  {
    // var_dump($emailData);
    // die();
    // if ( isset($emailData["cc"]) ) {
    //   // $emailData["cc"] = null;
    //   $this->validateEmails(array_merge(is_array($emailData["to"])? $emailData["to"] : [$emailData["to"]], [$emailData["from"], $emailData["cc"]]));
    // }else{
    //   $this->validateEmails(array_merge(is_array($emailData["to"])? $emailData["to"] : [$emailData["to"]], [$emailData["from"] ]));
    // }
    // die();


    $message = $this->configureEmail($emailData);

    // echo "------<pre>";
    // var_dump($message);
    // echo "------</pre>";
    // die();
    try {
      return $this->mailer->send($message);
      //echo "se envia";
      //sleep(10);
    } catch (Exception $ex) {
      echo $ex;
      die();
      throw new Exception("There was an error while the email was sended");
    }
  }

  public function getTemplate($bodyData, $emailCode)
  {
    return "";
  }
}

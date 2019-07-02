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

    public function __construct(EntityManagerInterface $em, FileManager $fileManager) {
        $this->em = $em;
        $this->fileManager = $fileManager;
    }

    private function validateEmails($emails) {
        foreach ($emails as $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format: " . $email);
            }
        }
    }
    
    private function configureEmail($emailData){
        $message = \Swift_Message::newInstance()
                ->setSubject($emailData["subject"])
                ->setFrom($emailData["from"])
                ->setContentType($emailData["contentType"] ?? 'text/html')
                ->setTo($emailData["to"])
                ->setBody($emailData["body"]);
        
        if ($emailData["bcc"]) {
            $message->setBcc($emailData["bcc"]);
        }
        if ($emailData["attatchments"]) {
            $fileDir = $this->getParameter('email_attatchments_directory');
            $files = $this->fileManager->uploadFiles($emailData["attatchments"], $fileDir);

            foreach ($files as $file) {
                $target_path = $fileDir . "\\" . $file->getFilename();
                $message->attach(Swift_Attachment::fromPath($target_path));
            }
            $this->em->flush();
        }
        
        return $message;
    }

    public function sendEmail($emailData) {

        $this->validateEmails([$emailData["from"], $emailData["to"]]);
        $message = $this->configureEmail($emailData);

        try {
            return $this->get('mailer')->send($message);
        } catch (Exception $ex) {
            throw new Exception("There was an error while the email was sended");
        }
    }

    public function getTemplate($bodyData, $emailCode) {
        return "";
    }

}

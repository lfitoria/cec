<?php

namespace App\Services\Utils;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WorkLog;
use Symfony\Component\Security\Core\Security;

class LogManager {

  private $em;
  private $user;

  public function __construct(EntityManagerInterface $em, Security $security) {
    $this->em = $em;
    $this->user = $security->getUser();
  }

  public function insertLog($logData) {
    $log = new WorkLog();
    $log->setDate(new \DateTime());
    $log->setDescription($logData["description"]);
    $log->setUser($this->user);
    $log->setRequest($logData["request"] ?? null);
    $log->setEvalRequest($logData["eval_request"] ?? null);
    $log->setPreEvalRequest($logData["pre_eval_request"] ?? null);

    $this->em->persist($log);
    $this->em->flush();
  }

  public function deleteLog($log) {
    if ($log) {
      $this->em->remove($log);
      $this->em->flush();

      return ['wasDeleted' => true];
    }
    return ['wasDeleted' => false];
  }

}

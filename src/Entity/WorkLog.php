<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="work_log")
 * @ORM\Entity
 */
class WorkLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="LdapUser", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;
    
    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="observations", type="string", length=1000, nullable=true)
     */
    private $observations;


    /**
     * @ORM\ManyToOne(targetEntity="ProjectRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=true)
     */
    private $request;

    /**
     * @ORM\ManyToOne(targetEntity="EvalRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=true)
     */
    private $eval_request;

    /**
     * @ORM\ManyToOne(targetEntity="PreEvalRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pre_eval_request;
    
    function getId() {
        return $this->id;
    }

    function getDescription() {
        return $this->description;
    }

    function getUser() {
        return $this->user;
    }

    function getRequest() {
        return $this->request;
    }

    function getEvalRequest() {
        return $this->eval_request;
    }

    function getPreEvalRequest() {
        return $this->pre_eval_request;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setRequest($request) {
        $this->request = $request;
    }

    function setEvalRequest($eval_request) {
        $this->eval_request = $eval_request;
    }

    function setPreEvalRequest($pre_eval_request) {
        $this->pre_eval_request = $pre_eval_request;
    }
    
    function getDate(): \DateTime {
        return $this->date;
    }

    function setDate(\DateTime $date) {
        $this->date = $date;
    }
    
    function getObservations() {
      return $this->observations;
    }

    function setObservations( $observations) {
      $this->observations = $observations;
    }



}
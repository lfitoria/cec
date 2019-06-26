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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="ProjectRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=false)
     */
    private $request;

    /**
     * @ORM\ManyToOne(targetEntity="EvalRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=false)
     */
    private $eval_request;

    /**
     * @ORM\ManyToOne(targetEntity="PreEvalRequest", inversedBy="work_log")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pre_eval_request;


}
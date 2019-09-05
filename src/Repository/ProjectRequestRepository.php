<?php

namespace App\Repository;

use App\Entity\ProjectRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProjectRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectRequest[]    findAll()
 * @method ProjectRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRequestRepository extends ServiceEntityRepository {

  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, ProjectRequest::class);
  }

  public function getProjectByEvaluator($evaluator, $state) {
    return $this->createQueryBuilder('ProjectRequest')
                    ->andWhere(':user MEMBER OF ProjectRequest.users')
                    ->andWhere('ProjectRequest.state = :state')
                    ->setParameter('user', $evaluator)
                    ->setParameter('state', $state)
                    ->getQuery()
                    ->getResult();
  }

}

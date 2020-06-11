<?php

namespace App\Repository;

use App\Entity\PreEvalRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PreEvalRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method PreEvalRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method PreEvalRequest[]    findAll()
 * @method PreEvalRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreEvalRequestRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, PreEvalRequest::class);
    }

    public function getAllPreEvalInfo($request) {
        return $this->createQueryBuilder('PreEvalInfo')
                        ->andWhere('PreEvalInfo.request = :request')
                        ->setParameter('request', $request)
                        ->orderBy('PreEvalInfo.date', 'ASC')
                        ->getQuery()
                        ->getResult()
                        ;
    }

    // /**
    //  * @return Criterion[] Returns an array of Criterion objects
    //  */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('c.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Criterion
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */
}

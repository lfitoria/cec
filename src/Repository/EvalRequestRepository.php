<?php

namespace App\Repository;

use App\Entity\EvalRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EvalRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvalRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvalRequest[]    findAll()
 * @method EvalRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalRequestRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, EvalRequest::class);
    }

    public function getAllEvalInfo($request) {
        return $this->createQueryBuilder('EvalInfo')
                        ->andWhere('EvalInfo.request = :request')
                        ->setParameter('request', $request)
                        ->orderBy('EvalInfo.date', 'ASC')
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

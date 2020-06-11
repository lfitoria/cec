<?php

namespace App\Repository;

use App\Entity\EthicEvalRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EthicEvalRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EthicEvalRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EthicEvalRequest[]    findAll()
 * @method EthicEvalRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EthicEvalRequestRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, EthicEvalRequest::class);
    }

    public function getEthicEvalRequestByRequest($request) {
        return $this->createQueryBuilder('EthicEvalRequest')
                        ->andWhere('EthicEvalRequest.request = :request')
                        ->setParameter('request', $request)
                        ->getQuery()
                        ->getOneOrNullResult();
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

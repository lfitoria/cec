<?php

namespace App\Repository;

use App\Entity\Criterion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Criterion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Criterion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Criterion[]    findAll()
 * @method Criterion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CriterionRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Criterion::class);
    }

    public function createPopulationQueryBuilder($code) {
        return $this->createQueryBuilder('Criterion')
                        ->andWhere('Criterion.code = :code')
                        ->setParameter('code', $code);
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

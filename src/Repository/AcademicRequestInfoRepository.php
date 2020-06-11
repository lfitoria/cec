<?php

namespace App\Repository;

use App\Entity\AcademicRequestInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcademicRequestInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcademicRequestInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcademicRequestInfo[]    findAll()
 * @method AcademicRequestInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcademicRequestInfoRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, AcademicRequestInfo::class);
    }

    public function getAcademicRequestInfoByRequest($request) {
        return $this->createQueryBuilder('AcademicRequestInfo')
                        ->andWhere('AcademicRequestInfo.request = :request')
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

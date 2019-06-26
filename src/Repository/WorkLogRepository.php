<?php

namespace App\Repository;

use App\Entity\WorkLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WorkLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkLog[]    findAll()
 * @method WorkLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkLogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WorkLog::class);
    }

    // /**
    //  * @return WorkLog[] Returns an array of WorkLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkLog
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

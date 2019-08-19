<?php

namespace App\Repository;

use App\Entity\TeamWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TeamWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamWork[]    findAll()
 * @method TeamWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamWorkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TeamWork::class);
    }

    // /**
    //  * @return TeamWork[] Returns an array of TeamWork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamWork
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

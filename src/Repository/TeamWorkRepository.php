<?php

namespace App\Repository;

use App\Entity\TeamWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamWork[]    findAll()
 * @method TeamWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamWork::class);
    }
}

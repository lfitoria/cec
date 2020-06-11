<?php

namespace App\Repository;

use App\Entity\WorkLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkLog[]    findAll()
 * @method WorkLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkLog::class);
    }

    public function getExternalCollaborationByProject($em, $project_id) {
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT
                c.convenio as numero, c.nombre,
                isnull(e.descrip,'') as entidad,
                co.descrip as tipo,
                isnull(xp.cuenta,'') cuenta, isnull(xp.monto,0) monto,
                isnull(xp.descripcion,'') descripcion
            FROM convenios c
                LEFT JOIN  xproconvent xp on xp.convenio = c.convenio
                LEFT JOIN codigos co on co.codigo = c.tipo
                LEFT JOIN entidades e on e.entidad = xp.entidad
            where
                c.proyecto = '$project_id' and
                co.tipo = 34;");
        $statement->execute();

        $results = $statement->fetchAll();
        return $results;
    }

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

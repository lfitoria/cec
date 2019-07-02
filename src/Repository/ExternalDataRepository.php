<?php

namespace App\Repository;

use App\Entity\UsersRoles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UsersRoles|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersRoles|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersRoles[]    findAll()
 * @method UsersRoles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternalDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UsersRoles::class);
    }

    /**
      * @return UsersRoles[] Returns an array of UsersRoles objects
      */
    public function getSipProjectById($em, $project_id) {
        
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            select xprouni.unidadc as codigo_unidad, proyectos.descrip as nombre, proyectos.proyecto as codigo_proyecto, unidades.descrip as unidad, TI.descrip AS tipo_invest, CR.descrip as tipo_finan,  
					EP.descrip as estado, descr_ubi as ubicacion, TP.descrip as tipo_proyecto 
                    From proyectos, xprouni, codigos as TI,codigos as CR,codigos as EP, ubicacion,codigos as TP, unidades  
                    where proyecto = '$project_id' 
                    and unidades.unidad = xprouni.unidadc  
                    and tipoc = 1  
                    and xprouni.proyectoc = proyectos.proyecto  
                    and TI.tipo = 13 and TI.codigo = tipo_invest  
                    and CR.tipo = 2  and CR.codigo = tipo_financ  
                    and EP.tipo = 12 and EP.codigo = estado_proy  
                    and ubicacion.ubicacion = proyectos.ubicacion  
                    and TP.tipo = 21 and TP.codigo = tipo_proy");

        $statement->execute();

        $results = $statement->fetchAll();
        return $results[0];
    }
}

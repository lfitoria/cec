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
class UsersRolesRepository extends ServiceEntityRepository {

  public function __construct(RegistryInterface $registry) {
    parent::__construct($registry, UsersRoles::class);
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
    public function findOneBySomeField($value): ?UsersRoles
    {
    return $this->createQueryBuilder('u')
    ->andWhere('u.exampleField = :val')
    ->setParameter('val', $value)
    ->getQuery()
    ->getOneOrNullResult()
    ;
    }
   */

  public function getEstudentById($em, $estudent_id) {
    $query = 'SELECT * FROM v_vi_estudiante_activo WHERE carne = :estudent_id';
    try {

      $connection = $em->getConnection();
      $statement = $connection->prepare($query);
      $statement->bindValue('estudent_id', $estudent_id);
      $statement->execute();

      $results = $statement->fetchAll();
    } catch (\Exception $e) {
      var_dump($e);
      return null;
    }
    return $results;
  }

  

  public function getProjectById($em, $id) {

    $connection = $em->getConnection();
    $statement = $connection->prepare("
            select xprouni.unidadc as codigo_unidad, proyectos.descrip as nombre, proyectos.proyecto as codigo_proyecto, unidades.descrip as unidad, TI.descrip AS tipo_invest, CR.descrip as tipo_finan,  
                    EP.descrip as estado, descr_ubi as ubicacion, TP.descrip as tipo_proyecto 
                    From proyectos, xprouni, codigos as TI,codigos as CR,codigos as EP, ubicacion,codigos as TP, unidades  
                    where proyecto = '$id' 
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

    return (!empty($results)) ? $results[0] : null;
  }

  public function getMetodologiaByProject($em, $id) {
    $connection = $em->getConnection();
    $statement = $connection->prepare("
                SELECT * FROM proyectos_info_adicional where proyecto = '$id'");
    $statement->execute();

    $results = $statement->fetchAll();
    return isset($results[0]) ? $results[0] : false;
  }

}

<?php

namespace App\Services\Utils;

use Doctrine\ORM\EntityManagerInterface;
use App\Services\Utils\FileManager;

class ExternalDataManager {

  private $em;
  private $fileManager;
  private $transport;
  private $mailer;

  public function __construct() {
    
  }

  public function getSIPProjectByCode($em, $projectCode) {

    $connection = $em->getConnection();
    $statement = $connection->prepare("
            select xprouni.unidadc as codigo_unidad, proyectos.descrip as nombre, proyectos.proyecto as codigo_proyecto, unidades.descrip as unidad, TI.descrip AS tipo_invest, CR.descrip as tipo_finan,  
					EP.descrip as estado, descr_ubi as ubicacion, TP.descrip as tipo_proyecto 
                    From proyectos, xprouni, codigos as TI,codigos as CR,codigos as EP, ubicacion,codigos as TP, unidades  
                    where proyecto = '$projectCode' 
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

  public function getExternalCollaborationByProject($em, $projectCode) {
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
                c.proyecto = '$projectCode' and
                co.tipo = 34;");
    $statement->execute();

    $results = $statement->fetchAll();
    return $results;
  }

  public function getAcademicUnitByProject($em, $unitId) {

    $connection = $em->getConnection();
    $statement = $connection->prepare(
            "SELECT 
                    unidades.descrip AS UNIDADA 
                FROM 
                    xprouni, unidades
                WHERE 
                    proyectoc = '" . $unitId . "' AND 
                    unidades.unidad = xprouni.unidadc AND 
                    tipoc = 1"
    );

    $statement->execute();

    $results = $statement->fetchAll();
    return isset($results[0]) ? $results[0] : null;
  }

  public function getResearchersByProject($em, $projectCode) {

    $connection = $em->getConnection();
    $statement = $connection->prepare(
            "Select datos_per.cedula,apellido1,apellido2,nombre,codigos.descrip AS PARTICIPA,(rtrim(convert(char,dedicacion.dedicacion)) + ' - ' + dedicacion.descrip) AS TIEMPO, 
			 convert(char(10),fec_inicio,103) as fec_inicioF, 
			 convert(char(10),fec_final,103) as fec_finalF, 
    			monto_ca 
				From xproinv, codigos, dedicacion, datos_per  
			   WHERE xproinv.proyecto = '$projectCode'
			   and datos_per.cedula = xproinv.cedula and codigos.codigo = participacion and codigos.tipo = 1 
			   and dedicacion.dedicacion = xproinv.dedicacion 
			   order by codigos.descrip desc, fec_inicioF");

    $statement->execute();

    $results = $statement->fetchAll();
    return $results;
  }

  public function getPrincipalResearchersByProject($em, $projectCode) {

    $connection = $em->getConnection();
    $statement = $connection->prepare(
            "Select datos_per.cedula,apellido1,apellido2,nombre,codigos.descrip AS PARTICIPA,(rtrim(convert(char,dedicacion.dedicacion)) + ' - ' + dedicacion.descrip) AS TIEMPO, 
			 convert(char(10),fec_inicio,103) as fec_inicioF, 
			 convert(char(10),fec_final,103) as fec_finalF, 
    			monto_ca 
				From xproinv, codigos, dedicacion, datos_per  
			   WHERE xproinv.proyecto = '$projectCode'
			   and datos_per.cedula = xproinv.cedula and codigos.codigo = participacion and codigos.tipo = 1 
			   and dedicacion.dedicacion = xproinv.dedicacion
               and codigos.descrip = 'PRINCIPAL' or codigos.descrip = 'COORDINADOR' 
			   order by codigos.descrip desc, fec_inicioF");

    $statement->execute();

    $results = $statement->fetchAll();
    return $results;
  }

  public function getStudentById($em, $studentId) {
    $query = 'SELECT * FROM v_vi_estudiante_activo WHERE carne = :estudent_id';
    try {

      $connection = $em->getConnection();
      $statement = $connection->prepare($query);
      $statement->bindValue('estudent_id', $studentId);
      $statement->execute();

      $results = $statement->fetchAll();
    } catch (\Exception $e) {
      var_dump($e);
      return null;
    }
    return $results;
  }

  public function getInvesColaboradoresByProject($em, $project) {
    $connection = $em->getConnection();
    $statement = $connection->prepare("
                SELECT 
                    x.cedula, 
                    (RTRIM(d.nombre)+' '+RTRIM(d.apellido1)+' '+RTRIM(d.apellido2)) as nombre,
                    (RTRIM(c.descrip)+' '+RTRIM(cd.descrip)) as descrip, 
                    d.sexo, 
                    convert(char(10),x.fec_inicio,103) as fec_inicio, 
                    convert(char(10),x.fec_final,103) as fec_final
                
                FROM XPROINV x 
                inner join 
                    codigos c on c.codigo = x.participacion and c.tipo = 1  
                
                inner join 
                    datos_per d on d.cedula = x.cedula
                inner join 
                    codigos cd on cd.codigo = d.estado and cd.tipo = 4
                where 
                    x.proyecto = '" + trim($project) + "' and 
                    x.participacion = 1");
    $statement->execute();


    $results = $statement->fetchAll();

    return $results;
  }

}

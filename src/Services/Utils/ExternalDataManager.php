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

  public function getProjectInfoByCode($em, $projectCode) {
    
    $code = explode("-",$projectCode)[0];
    $year = explode("-",$projectCode)[1];
    
    $connection = $em->getConnection();
    $statement = $connection->prepare("SELECT    
    Proy.fec_inicio 'fecha_inicio',
    Proy.fec_fin 'fecha_final',
    formu.fec_registro 'fecha_registro',
    formu.nom_proyecto 'dsc_proyecto',
     
     formu.dsc_obj_general 'dsc_objetivo_general',
    
    formu.id_valor_estado 'id_estado_proyecto',    
    tipoproy.dsc_tipo_proyecto 'dsc_tipo_proyecto',
    
    MONTHS_BETWEEN(Proy.fec_fin, Proy.fec_inicio) 'duracion_meses',
    
    UnidEject.id_unidad_programatica 'id_unidad',
    UPPER(SegUnidExec.dsc_unidad_ejecutora) 'dsc_unidad'
from
     spp_proyecto Proy INNER join spp_formulario formu
        ON Proy.id_formulario = Formu.id_formulario AND Proy.id_periodo = Formu.id_periodo AND Proy.id_tipo_proyecto = Formu.id_tipo_proyecto
     INNER join spp_proyecto_unidad_ejecutora UnidEject
        ON Proy.id_formulario = UnidEject.id_formulario AND Proy.id_periodo = UnidEject.id_periodo AND Proy.id_tipo_proyecto = UnidEject.id_tipo_proyecto
     INNER join spp_formulario_origen_fondos fondos
        ON Proy.id_formulario = fondos.id_formulario AND Proy.id_periodo = fondos.id_periodo AND Proy.id_tipo_proyecto = fondos.id_tipo_proyecto
     INNER JOIN spp_tipo_proyecto tipoproy
        on formu.id_tipo_proyecto = tipoproy.id_tipo_proyecto
     
     inner join spp_estructura_programatica EstrcProg
        on UnidEject.id_periodo = EstrcProg.id_periodo AND UnidEject.id_unidad_programatica = EstrcProg.id_unidad_programatica
     inner join seguridad_unidad_ejecutora SegUnidExec
        on EstrcProg.id_empresa = SegUnidExec.id_empresa and EstrcProg.id_unidad_referencia = SegUnidExec.id_unidad_ejecutora 

WHERE
    Proy.id_formulario = '$code'    
    AND Proy.id_periodo = $year
    AND Proy.id_tipo_proyecto = 'Pry01'
    AND fondos.id_act_sustantiva = 2 
    AND UnidEject.ind_base = '1'  
    AND formu.id_valor_estado = 42;");

    $statement->execute();

    $results = $statement->fetchAll();
    return isset($results[0]) ? $results[0] : null;
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
            "Select DISTINCT datos_per.cedula,apellido1,apellido2,nombre,bitnet,codigos.descrip AS PARTICIPA
                From xproinv, codigos, dedicacion, datos_per  
               WHERE xproinv.proyecto = '$projectCode'
               and datos_per.cedula = xproinv.cedula and codigos.codigo = 1 and codigos.tipo = 1
               and dedicacion.dedicacion = xproinv.dedicacion");

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
  public function getInfoByProject($em, $project) {
    $connection = $em->getConnection();
    $statement = $connection->prepare("
                SELECT * FROM proyectos_info_adicional where proyecto = '$project'");
    $statement->execute();

    $results = $statement->fetchAll();
    return isset($results[0]) ? $results[0] : false;
  }
  public function getObjetivoPrincipalByProject($em, $project) {
    $connection = $em->getConnection();
    $statement = $connection->prepare("
                select tipo,descrip from objetivos where proyecto='$project' and tipo='G' order by linea");
    $statement->execute();

    $results = $statement->fetchAll();
    return isset($results[0]) ? $results[0] : false;
  }

}

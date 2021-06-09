<?php

error_reporting(E_ALL);

if (function_exists("oci_connect")) {
    echo "oci_connect found\n";
} else {
    echo "oci_connect not found\n";
    exit;
}

$host = 'produccion-bd.ucr.ac.cr';
$port = '1521';

// Oracle service name (instance)
$db_name     = 'UCR';
$db_username = "APVI_SISTEMA_INFORM_PROYECTOS";
$db_password = '$VI_1920_DB#ucr';

$tns = "(DESCRIPTION =
	(CONNECT_TIMEOUT=3)(RETRY_COUNT=0)
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = $db_name)
    )
  )";

try {
    $conn = oci_connect($db_username, $db_password, $tns);
    if (!$conn) {
        $e = oci_error();
        throw new Exception($e['message']);
    }
    echo "Connection OK\n";
    
    $stid = oci_parse($conn, 'SELECT
                   
                    UnidEject.id_unidad_programatica "id_unidad"

                    from spp_proyecto_unidad_ejecutora UnidEject
                    
                    WHERE

                    UnidEject.id_unidad_programatica = :unidad');
    
    $unidad = "06030300";
    $tipo = "Pry01";
    oci_bind_by_name($stid, ":unidad", $unidad);

    oci_execute($stid);
    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
        // Usar nombres de columna en mayúsculas para los índices del array asociativo
        echo $row[1] . " y " . $row['id_unidad'] . " son lo mismo<br>\n";
    }
    if (!$stid) {
        $e = oci_error($conn);
        throw new Exception($e['message']);
    }
    // Perform the logic of the query
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        throw new Exception($e['message']);
    }
    
    // Fetch the results of the query
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $row = array_change_key_case($row, CASE_LOWER);
        print_r($row);
        break;
    }
    
    // Close statement
    oci_free_statement($stid);
    
    // Disconnect
    oci_close($conn);
    
}
catch (Exception $e) {
    print_r($e);
}

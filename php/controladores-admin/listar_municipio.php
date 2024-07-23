<?php
include '../../config/config.php';
include '../conexion.php';

if (isset($_POST)) {

    $sql = "SELECT * FROM municipios";
    
    if (!empty($_POST["estado_id"])) {
        $estado = $_POST["estado_id"];
        $sql = "SELECT * FROM municipios WHERE estado_id = $estado";
    }
    
    $resultado = $conexion->query($sql);

    $datos = array();

    while ($row = $resultado->fetch_object()) {
        $datos[] = [
            "municipio_id" => $row->municipio_id,
            "nombre_municipio" => $row->nombre_municipio
        ];
    }

    $json = json_encode($datos, JSON_UNESCAPED_UNICODE);

    $resultado->free_result();
    $conexion->close();

    print_r($json);
}

?>
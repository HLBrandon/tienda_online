<?php
include '../../config/config.php';
include '../conexion.php';

if (isset($_POST)) {

    $sql = "SELECT * FROM ciudades";
    
    if (!empty($_POST["municipio_id"])) {
        $municipio = $_POST["municipio_id"];
        $sql = "SELECT * FROM ciudades WHERE municipio_id = $municipio";
    }
    
    $resultado = $conexion->query($sql);

    $datos = array();

    while ($row = $resultado->fetch_object()) {
        $datos[] = [
            "ciudad_id" => $row->ciudad_id,
            "nombre_ciudad" => $row->nombre_ciudad
        ];
    }

    $json = json_encode($datos, JSON_UNESCAPED_UNICODE);

    $resultado->free_result();
    $conexion->close();

    print_r($json);
}
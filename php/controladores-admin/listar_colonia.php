<?php
include '../../config/config.php';
include '../conexion.php';

if (isset($_POST)) {

    $sql = "SELECT * FROM colonia";
    
    if (!empty($_POST["ciudad_id"])) {
        $ciudad_id = $_POST["ciudad_id"];
        $sql = "SELECT * FROM colonia WHERE ciudad_id = $ciudad_id";
    }
    
    $resultado = $conexion->query($sql);

    $datos = array();

    while ($row = $resultado->fetch_object()) {
        $datos[] = [
            "colonia_id" => $row->colonia_id,
            "nombre_colonia" => $row->nombre_colonia
        ];
    }

    $json = json_encode($datos, JSON_UNESCAPED_UNICODE);

    $resultado->free_result();
    $conexion->close();

    print_r($json);
}
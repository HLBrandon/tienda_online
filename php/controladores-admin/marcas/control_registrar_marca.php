<?php

if ($_POST) {

    if (!empty($_POST["marca"])) {

        include '../../../config/config.php';
        include '../../conexion.php';
        
        $marca = $_POST["marca"];

        $sql = "INSERT INTO marcas (marca) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt -> bind_param("s", $marca);
        $stmt -> execute();

        $respuesta = [
            "success" => true,
            "icono" => "success",
            "mensaje" => "Marca registrada con exito"
        ];

    } else {
        $respuesta = [
            "success" => false,
            "icono" => "error",
            "mensaje" => "Debes completar todo el formulario"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

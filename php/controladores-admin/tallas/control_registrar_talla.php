<?php

if ($_POST) {

    if (!empty($_POST["talla"])) {

        include '../../../config/config.php';
        include '../../conexion.php';

        $talla = $_POST["talla"];

        $sql = "INSERT INTO tallas (medida_talla) VALUES (?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $talla);
        $stmt->execute();

        $respuesta = [
            "success" => true,
            "icono" => "success",
            "mensaje" => "Talla registrada con exito"
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

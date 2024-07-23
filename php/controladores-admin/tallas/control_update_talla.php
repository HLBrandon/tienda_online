<?php

if ($_POST) {

    if (md5($_POST["talla_id"]) == $_POST["token"]) {

        if (!empty($_POST["talla"])) {

            include '../../../config/config.php';
            include '../../conexion.php';

            $talla = $_POST["talla"];
            $talla_id = $_POST["talla_id"];

            $sql = "UPDATE tallas SET medida_talla = ? WHERE talla_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $talla, $talla_id);
            $stmt->execute();

            $stmt->close();
            $conexion->close();

            $respuesta = [
                "success" => true,
                "icono" => "success",
                "mensaje" => "Talla modificada con exito",
                "talla" => $talla
            ];
        } else {
            $respuesta = [
                "success" => false,
                "icono" => "error",
                "mensaje" => "Debes completar todo el formulario"
            ];
        }

    } else {
        $respuesta = [
            "success" => false,
            "icono" => "error",
            "mensaje" => "Oh no, parece que ha ocurrido un error"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

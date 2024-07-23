<?php

if ($_POST) {

    if (md5($_POST["marca_id"]) == $_POST["token"]) {

        if (!empty($_POST["marca"])) {

            include '../../../config/config.php';
            include '../../conexion.php';

            $marca = $_POST["marca"];
            $marca_id = $_POST["marca_id"];

            $sql = "UPDATE marcas SET marca = ? WHERE marca_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $marca, $marca_id);
            $stmt->execute();

            $respuesta = [
                "success" => true,
                "icono" => "success",
                "mensaje" => "Marca registrada con exito",
                "marca" => $marca
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

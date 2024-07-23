<?php

if (isset($_POST)) {

    if (!empty($_POST["genero"]) and !empty($_FILES["img"]["tmp_name"])) {

        $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));

        if ($formato == "jpg" || $formato == "png" || $formato == "jpeg") {

            include '../../../config/config.php';
            include '../../conexion.php';

            $genero = $_POST["genero"];
            $imagen = $_FILES["img"]["tmp_name"];

            $sql = "INSERT INTO generos (genero, img_genero) VALUES (?,'')";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $genero);
            $stmt->execute();

            $id = $conexion->insert_id;

            $nombreEnDirectoio = $id . "." . $formato; // example: 5.jpg
            $directorio = "img/generos/";
            $db_ruta = $directorio . $nombreEnDirectoio; // esto se inserta en la base de datos

            $url_mover_imagen = "../../../" . $directorio . $nombreEnDirectoio;

            $sql = "UPDATE generos SET img_genero = ? WHERE genero_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ss", $db_ruta, $id);
            $stmt->execute();

            if (move_uploaded_file($imagen, $url_mover_imagen)) {
                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Genero registrado con exito"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "Parece que ha ocurrido un error"
                ];
            }
            $stmt->close();
            $conexion->close();
        } else {
            $respuesta = [
                "success" => false,
                "icono" => "error",
                "mensaje" => "Solo aceptamos formatos JPEG, JPG, PNG"
            ];
        }
    } else {
        $respuesta = [
            "success" => false,
            "icono" => "error",
            "mensaje" => "Debes completar todo el formulario h"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

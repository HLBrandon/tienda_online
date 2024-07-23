<?php

if (isset($_POST)) {

    if (md5($_POST["genero_id"]) == $_POST["token"]) {

        if (!empty($_POST["genero"]) and !empty($_FILES["img"]["tmp_name"]) and !empty($_POST["img_ruta"])) {

            $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));

            if ($formato == "jpg" || $formato == "png" || $formato == "jpeg") {

                include '../../../config/config.php';
                include '../../conexion.php';

                $genero_id = $_POST["genero_id"];
                $genero = $_POST["genero"];
                $img_ruta = $_POST["img_ruta"];
                $imagen = $_FILES["img"]["tmp_name"];

                try {
                    unlink("../../../".$img_ruta);
                } catch (\Throwable $th) {
                    print_r($th);
                }

                $nombreEnDirectoio = $genero_id. "." . $formato; // example: 5.jpg
                $directorio = "img/generos/";
                $db_ruta = $directorio . $nombreEnDirectoio; // esto se inserta en la base de datos

                $url_mover_imagen = "../../../" . $directorio . $nombreEnDirectoio;

                if (move_uploaded_file($imagen, $url_mover_imagen)) {
                    $sql = "UPDATE generos SET genero = ?, img_genero = ? WHERE genero_id = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("sss", $genero, $db_ruta, $genero_id);
                    $stmt->execute();

                    $respuesta = [
                        "success" => true,
                        "icono" => "success",
                        "mensaje" => "Genero registrado con exito",
                        "texto" => "Los cambios pueden tardar algunos minutos en verse reflejados"
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

<?php

if (isset($_POST)) {
    if (!empty($_POST["categoria"]) and !empty($_FILES["img"]["tmp_name"])) {
        $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));

        if ($formato == "jpeg" || $formato == "jpg" || $formato == "png") {
            include '../../../config/config.php';
            include '../../conexion.php';

            $categoria = $_POST["categoria"];
            $imagen = $_FILES["img"]["tmp_name"];

            $sql = "INSERT INTO categorias (categoria, img_categoria) VALUES (?,'')";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $categoria);
            $stmt->execute();

            $id = $conexion->insert_id;

            $nombreEnDirectoio = $id . "." . $formato; // 5.jpg
            $directorio = "img/categorias/";
            $db_ruta = $directorio . $nombreEnDirectoio; // esto va para la base de datos

            $url_mover_imagen = "../../../" . $directorio . $nombreEnDirectoio;

            if (move_uploaded_file($imagen, $url_mover_imagen)) {
                $sql = "UPDATE categorias SET img_categoria = ? WHERE categoria_id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ss", $db_ruta, $id);
                $stmt->execute();

                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Categoria creada con exito"
                ];

            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "Error al subir imagen al servidor"
                ];
            }

        } else {
            $respuesta = [
                "success" => false,
                "icono" => "error",
                "mensaje" => "Solo se aceptan imagenes JPEG, JPG o PNG"
            ];
        }
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

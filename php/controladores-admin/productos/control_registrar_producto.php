<?php

if ($_POST) {

    if (!empty($_POST["producto"]) and !empty($_FILES["img"]["tmp_name"]) and !empty($_POST["categoria"]) and !empty($_POST["marca"]) and !empty($_POST["descripcion"]) and !empty($_POST["generos"])) {

        $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));

        if ($formato == "jpg" || $formato == "jpeg" || $formato == "png") {

            include '../../../config/config.php';
            include '../../conexion.php';

            $producto    = $_POST["producto"];
            $imagen      = $_FILES["img"]["tmp_name"];
            $categoria   = $_POST["categoria"];
            $marca       = $_POST["marca"];
            $descripcion = $_POST["descripcion"];
            $generos     = $_POST["generos"];

            $sql  = "INSERT INTO productos (nombre_producto, marca_id, descripcion, img_producto, categoria_id) VALUES (?,?,?,'',?)";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssss", $producto, $marca, $descripcion, $categoria);
            $stmt->execute();

            $id = $conexion->insert_id;

            $nombreEnDirectorio = $id . "." . $formato; // 8.jpg
            $directorio = "img/productos/";
            $url_db = $directorio . $nombreEnDirectorio; // esto va para la base

            $url_mover = "../../../" . $url_db;

            if (move_uploaded_file($imagen, $url_mover)) {
                $sql = "UPDATE productos SET img_producto = ? WHERE producto_id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("ss", $url_db, $id);
                $stmt->execute();

                $sql = "INSERT INTO producto_genero (producto_id, genero_id) VALUES (?,?)";
                $stmt = $conexion->prepare($sql);

                foreach ($generos as $g) {
                    $stmt->bind_param("ss", $id, $g);
                    $stmt->execute();
                }

                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Producto creado con exito"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "Error al subir imagen al servidor"
                ];
            }

            $sql = "";
            $stmt->close();
            $conexion->close();
        } else {
            $respuesta = [
                "success" => false,
                "icono" => "error",
                "mensaje" => "Solo aceptamos imagenes: jpeg/jpg/png"
            ];
        }
    } else {
        $respuesta = [
            "success" => false,
            "icono" => "warning",
            "mensaje" => "Debes completar todo el formulario"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

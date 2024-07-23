<?php

function eliminar_generos($conexion, $producto_id, $generos): void
{
    $sql = "DELETE FROM producto_genero WHERE producto_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $producto_id);
    $stmt->execute();

    $sql = "INSERT INTO producto_genero (producto_id, genero_id) VALUES (?,?)";
    $stmt = $conexion->prepare($sql);

    foreach ($generos as $g) {
        $stmt->bind_param("ss", $producto_id, $g);
        $stmt->execute();
    }
}

if (isset($_POST)) {

    if (md5($_POST["producto_id"]) == $_POST["token"]) {
        if (!empty($_POST["producto"]) and !empty($_POST["categoria"]) and !empty($_POST["marca"]) and !empty($_POST["descripcion"]) and !empty($_POST["generos"])) {

            include '../../../config/config.php';
            include '../../conexion.php';

            $producto_id = $_POST["producto_id"];
            $producto    = $_POST["producto"];
            $categoria   = $_POST["categoria"];
            $marca       = $_POST["marca"];
            $descripcion = $_POST["descripcion"];
            $generos     = $_POST["generos"];

            if (empty($_FILES["img"]["tmp_name"])) {
                $sql = "UPDATE productos SET nombre_producto = ?, marca_id = ?, descripcion = ?, categoria_id = ? WHERE producto_id = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("sssss", $producto, $marca, $descripcion, $categoria, $producto_id);
                $stmt->execute();

                eliminar_generos($conexion, $producto_id, $generos);

                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Modificado con exito"
                ];
                $stmt->close();
                $conexion->close();
            } else {
                $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));
                if ($formato == "jpeg" || $formato == "jpg" || $formato == "png") {

                    $imagen = $_FILES["img"]["tmp_name"];
                    $img_ruta = $_POST["img_ruta"];

                    try {
                        unlink("../../../" . $img_ruta);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                    $nombreEnDirectoio = $producto_id . "." . $formato;
                    $directorio = "img/productos/";
                    $db_ruta = $directorio . $nombreEnDirectoio; // 8.png

                    $url_mover = "../../../" . $db_ruta;

                    if (move_uploaded_file($imagen, $url_mover)) {
                        $sql = "UPDATE productos SET nombre_producto = ?, marca_id = ?, descripcion = ?, img_producto = ?, categoria_id = ? WHERE producto_id = ?";
                        $stmt = $conexion->prepare($sql);
                        $stmt->bind_param("ssssss", $producto, $marca, $descripcion, $db_ruta, $categoria, $producto_id);
                        $stmt->execute();

                        eliminar_generos($conexion, $producto_id, $generos);

                        $respuesta = [
                            "success" => true,
                            "icono" => "success",
                            "mensaje" => "Modificado con exito"
                        ];
                        $stmt->close();
                        $conexion->close();
                    } else {
                        $respuesta = [
                            "success" => false,
                            "icono" => "error",
                            "mensaje" => "Error el subir al servidor"
                        ];
                    }
                } else {
                    $respuesta = [
                        "success" => false,
                        "icono" => "error",
                        "mensaje" => "Solo aceptamos imagenes JPEG/JPG/PNG"
                    ];
                }
            }
        } else {
            $respuesta = [
                "success" => false,
                "icono" => "warning",
                "mensaje" => "Debes llenar todo el formulario"
            ];
        }
    } else {
        $respuesta = [
            "success" => false,
            "icono" => "error",
            "mensaje" => "Error"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

<?php

if (isset($_POST)) {

    if (md5($_POST["categoria_id"]) == $_POST["token"]) {

        if (!empty($_POST["categoria"]) and !empty($_FILES["img"]["tmp_name"])) {
            $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));

            if ($formato == "jpeg" || $formato == "jpg" || $formato == "png") {

                $categoria = $_POST["categoria"];
                $imagen = $_FILES["img"]["tmp_name"];
                $img_ruta = $_POST["img_ruta"];
                $categoria_id = $_POST["categoria_id"];

                try {
                    unlink("../../../" . $img_ruta);
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $nombreEnDirectoio = $categoria_id . "." . $formato;
                $directorio = "img/categorias/";
                $db_ruta = $directorio . $nombreEnDirectoio;

                $url_mover_imagen = "../../../" . $db_ruta;

                if (move_uploaded_file($imagen, $url_mover_imagen)) {
                    include '../../../config/config.php';
                    include '../../conexion.php';

                    $sql = "UPDATE categorias SET categoria = ?, img_categoria = ? WHERE categoria_id = ?";
                    $stmt = $conexion->prepare($sql);
                    $stmt->bind_param("sss", $categoria, $db_ruta, $categoria_id);
                    $stmt->execute();

                    $stmt->close();
                    $conexion->close();

                    $respuesta = [
                        "success" => true,
                        "icono" => "success",
                        "mensaje" => "Categoria modificada con exito",
                        "texto" => "Los cambios pueden tardar algunos segundos en verse reflejados"
                    ];
                } else {
                    $respuesta = [
                        "success" => false,
                        "icono" => "error",
                        "mensaje" => "Error al subir al servidor"
                    ];
                }
            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "Solo aceptamos imagenes JPEG, JPG o PNG"
                ];
            }
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
            "mensaje" => "Parece que algo anda mal"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

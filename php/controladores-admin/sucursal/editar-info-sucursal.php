<?php

if (isset($_POST)) {

    if (!empty($_POST["nombre_sucursal"]) and !empty($_POST["direccion_sucursal"]) and !empty($_POST["cif_sucursal"]) and !empty($_POST["telefono_sucursal"]) and !empty($_POST["correo_sucursal"])) {

        include '../../../config/config.php';
        include '../../conexion.php';

        $nombre    = $_POST["nombre_sucursal"];
        $direccion = $_POST["direccion_sucursal"];
        $cif       = $_POST["cif_sucursal"];
        $telefono  = $_POST["telefono_sucursal"];
        $correo    = $_POST["correo_sucursal"];

        if (empty($_FILES["img"]["tmp_name"])) {
            # entra si esta vacio, no cambia la imagen
            $sql = "UPDATE sucursales SET nombre_sucursal = ?, direccion = ?, cif = ?, telefono = ?, correo = ? WHERE sucursal_id = 1";
            $pr = $conexion->prepare($sql);
            $pr->bind_param("sssss", $nombre, $direccion, $cif, $telefono, $correo);
            $pr->execute();

            $pr->close();

            $repuesta = [
                "status" => true,
                "icono" => "success",
                "titulo" => "Cambios completados",
                "mensaje" => "Los cambios pueden tardar algunos segundos",
                "sucursal" => $nombre,
            ];
        } else {
            # entra si has enviado una imagen, quieres cambiar el logo
            $formato = strtolower(pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));
            if ($formato == "jpeg" || $formato == "jpg" || $formato == "png") {

                $imagen = $_FILES["img"]["tmp_name"];
                $img_ruta = $_POST["img_ruta"];

                try {
                    unlink("../../../" . $img_ruta);
                } catch (\Throwable $th) {
                    //throw $th;
                }

                $nombreEnDirectorio = "logo." . $formato; # logo.jpg logo.png logo.jpeg
                $directorio = "img/sucursal/";
                $db_ruta = $directorio . $nombreEnDirectorio; # esto va para la base de datos
                $ruta_mover = "../../../" . $db_ruta;

                if (move_uploaded_file($imagen, $ruta_mover)) {
                    $sql = "UPDATE sucursales SET nombre_sucursal = ?, img_logo = ?, direccion = ?, cif = ?, telefono = ?, correo = ? WHERE sucursal_id = 1";
                    $pr = $conexion->prepare($sql);
                    $pr->bind_param("ssssss", $nombre, $db_ruta, $direccion, $cif, $telefono, $correo);
                    $pr->execute();
                    $pr->close();

                    $repuesta = [
                        "status" => true,
                        "icono" => "success",
                        "titulo" => "Cambios completados",
                        "mensaje" => "Los cambios pueden tardar algunos segundos",
                        "sucursal" => $nombre,
                    ];

                } else {
                    $repuesta = [
                        "status" => false,
                        "icono" => "error",
                        "titulo" => "DO NOT MOVE FILE",
                        "mensaje" => "Error Update File in Server"
                    ];
                }
            } else {
                $repuesta = [
                    "status" => false,
                    "icono" => "error",
                    "titulo" => "No es una imagen",
                    "mensaje" => "Solo aceptamos imagenes JPEG/JPG/PNG"
                ];
            }
        }

        $conexion->close();
        $sql = "";
    } else {
        $repuesta = [
            "status" => false,
            "icono" => "error",
            "titulo" => "Campos Vacios",
            "mensaje" => "Debes completar todo el formulario"
        ];
    }

    $json = json_encode($repuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

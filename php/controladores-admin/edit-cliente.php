<?php

if (isset($_POST)) {

    if (!empty($_POST["cliente"]) and !empty($_POST["token"])) {

        if (md5($_POST["cliente"]) == $_POST["token"]) {

            include '../../config/config.php';
            include '../conexion.php';

            $cliente_id = $_POST["cliente"];
            $sql = $conexion->query("SELECT * FROM usuarios WHERE usuario_id = $cliente_id");

            if ($row = $sql->fetch_object()) {
                $respuesta = [
                    "nombre" => $row->nombre,
                    "apellidos" => $row->apellidos,
                    "correo" => $row->correo,
                    "calle" => $row->calle,
                    "num_ex" => $row->num_ex,
                    "num_in" => $row->num_in,
                    "codigo_postal" => $row->codigo_postal,
                    "estado_id" => $row->estado_id,
                    "municipio_id" => $row->municipio_id,
                    "ciudad_id" => $row->ciudad_id,
                    "colonia_id" => $row->colonia_id,
                ];
            }

        } else {
            $respuesta = [
                "success" => false,
                "mensaje" => "Data incorrect"
            ];
        }
    } else {
        $respuesta = [
            "success" => false,
            "mensaje" => "Data empty"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

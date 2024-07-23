<?php

if (isset($_POST)) {

    if (md5($_POST["cliente"]) == $_POST["token"]) {
        if (!empty($_POST["nombre"]) and !empty($_POST["apellidos"]) and !empty($_POST["correo"]) and !empty($_POST["calle"]) and !empty($_POST["num_ex"]) and !empty($_POST["codigo_postal"]) and !empty($_POST["estado"]) and !empty($_POST["municipio"]) and !empty($_POST["ciudad"]) and !empty($_POST["colonia"])) {

            include '../../config/config.php';
            include '../conexion.php';

            $nombre = trim($_POST["nombre"]);
            $apellidos = trim($_POST["apellidos"]);
            $correo = trim($_POST["correo"]);
            $calle = trim($_POST["calle"]);
            $num_ex = trim($_POST["num_ex"]);
            $num_in = trim($_POST["num_in"]);
            $codigo_postal = trim($_POST["codigo_postal"]);
            $estado = trim($_POST["estado"]);
            $municipio = trim($_POST["municipio"]);
            $ciudad = trim($_POST["ciudad"]);
            $colonia = trim($_POST["colonia"]);
            $usuario_id = trim($_POST["cliente"]);

            $sql = "UPDATE usuarios SET nombre = ?, apellidos = ?, calle = ?, num_ex = ?, num_in = ?, codigo_postal = ?, colonia_id = ?, ciudad_id = ?, municipio_id = ?, estado_id = ?, correo = ? WHERE usuario_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("ssssssssssss", $nombre, $apellidos, $calle, $num_ex, $num_in, $codigo_postal, $colonia, $ciudad, $municipio, $estado, $correo, $usuario_id);
            if ($stmt->execute()) {
                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Cliente actualizado"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "ERROR FATAL EXECUTE LINE 26"
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
            "mensaje" => "Error"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

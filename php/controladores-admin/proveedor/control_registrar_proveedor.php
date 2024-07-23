<?php

if (isset($_POST)) {

    if (!empty($_POST["nombre"]) and !empty($_POST["direccion"]) and !empty($_POST["correo"]) and !empty($_POST["telefono"])) {

        include '../../../config/config.php';
        include '../../conexion.php';

        $nombre = trim($_POST["nombre"]);
        $direccion = trim($_POST["direccion"]);
        $correo = trim($_POST["correo"]);
        $telefono = trim($_POST["telefono"]);

        $sql = "INSERT INTO proveedores (nombre_proveedor, direccion, correo, telefono)
                VALUES (?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssss", $nombre, $direccion, $correo, $telefono);
        if ($stmt->execute()) {
            $respuesta = [
                "success" => true,
                "icono" => "success",
                "mensaje" => "Proveedor creado con exito"
            ];
        } else {
            $respuesta = [
                "success" => false,
                "mensaje" => "ERROR FATAL EXECUTE LINE 26"
            ];
        }
    } else {
        $respuesta = [
            "success" => false,
            "mensaje" => "Debes completar todo el formulario"
        ];
    }

    $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    print_r($json);
}

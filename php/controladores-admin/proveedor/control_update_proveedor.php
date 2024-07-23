<?php

if (isset($_POST)) {

    if (md5($_POST["proveedor"]) == $_POST["token"]) {
        if (!empty($_POST["nombre"]) and !empty($_POST["direccion"]) and !empty($_POST["correo"]) and !empty($_POST["telefono"])) {

            include '../../../config/config.php';
            include '../../conexion.php';

            $nombre = trim($_POST["nombre"]);
            $direccion = trim($_POST["direccion"]);
            $correo = trim($_POST["correo"]);
            $telefono = trim($_POST["telefono"]);
            $proveedor_id = trim($_POST["proveedor"]);

            $sql = "UPDATE proveedores SET nombre_proveedor = ?, direccion = ?, telefono = ?, correo = ? WHERE proveedor_id = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $direccion, $telefono, $correo, $proveedor_id);
            if ($stmt->execute()) {
                $respuesta = [
                    "success" => true,
                    "icono" => "success",
                    "mensaje" => "Proveedor actualizado"
                ];
            } else {
                $respuesta = [
                    "success" => false,
                    "icono" => "error",
                    "mensaje" => "ERROR FATAL EXECUTE LINE 26"
                ];
            }
            $stmt->close();
            $conexion->close();
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

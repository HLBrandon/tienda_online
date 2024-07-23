<?php

if (isset($_POST)) {

    if (!empty($_POST["usuario_id"])) {

        include '../../config/config.php';
        include '../conexion.php';
        $usuario_id = $_POST["usuario_id"];

        $stmt = $conexion->prepare("UPDATE usuarios SET acceso = 1 WHERE usuario_id = ?");
        $stmt->bind_param("s", $usuario_id);
        if ($stmt->execute()) {
            $respuesta = [
                "success" => true,
                "Acceso aceptado"
            ];
        } else {
            $respuesta = [
                "success" => false,
                "error"
            ];
        }

        $stmt->close();
        $conexion->close();

        $json = json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        print_r($json);
        
    }

}
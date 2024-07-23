<?php

if (isset($_POST)) {
    include '../../config/config.php';
    include '../conexion.php';

    if (!empty($_POST["nombre"]) and !empty($_POST["apellidos"]) and !empty($_POST["correo"]) and !empty($_POST["clave"]) and !empty($_POST["calle"]) and !empty($_POST["num_ex"]) and !empty($_POST["codigo_postal"]) and !empty($_POST["estado"]) and !empty($_POST["municipio"]) and !empty($_POST["ciudad"]) and !empty($_POST["colonia"])) {
        $nombre = trim($_POST["nombre"]);
        $apellidos = trim($_POST["apellidos"]);
        $correo = trim($_POST["correo"]);
        $clave = trim($_POST["clave"]);
        $clave_hash = password_hash($clave, PASSWORD_DEFAULT);
        $calle = trim($_POST["calle"]);
        $num_ex = trim($_POST["num_ex"]);
        $num_in = trim($_POST["num_in"]);
        $codigo_postal = trim($_POST["codigo_postal"]);
        $estado = trim($_POST["estado"]);
        $municipio = trim($_POST["municipio"]);
        $ciudad = trim($_POST["ciudad"]);
        $colonia = trim($_POST["colonia"]);

        $sql = "INSERT INTO usuarios (nombre, apellidos, calle, num_ex, num_in, codigo_postal, colonia_id, ciudad_id, municipio_id, estado_id, correo, clave)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssssssssssss", $nombre,$apellidos,$calle,$num_ex,$num_in,$codigo_postal,$colonia,$ciudad,$municipio,$estado,$correo,$clave_hash);
        if ($stmt->execute()) {
            $respuesta = [
                "success" => true,
                "mensaje" => "Cliente creado con exito"
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

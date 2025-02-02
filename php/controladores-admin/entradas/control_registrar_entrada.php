<?php

if (isset($_POST)) {

    if (!empty($_POST["proveedor"]) and !empty($_POST["producto"]) and !empty($_POST["talla"]) and !empty($_POST["precio"]) and !empty($_POST["stock"])) {

        include __DIR__ . "/../../../config/config.php";
        include __DIR__ . "/../../conexion.php";

        $ps = $conexion->prepare("SELECT entrada_id FROM entradas WHERE proveedor_id = ? AND producto_id = ? AND talla_id = ?");
        $ps->bind_param("sss", $_POST["proveedor"], $_POST["producto"], $_POST["talla"]);
        $ps->execute();
        $rs = $ps->get_result();

        $sql = "";

        if ($rs->num_rows == 0) {
            # Es el primer registro
            $sql = "CALL registrar_entrada_primera(?, ?, ?, ?, ?)";
        } else {
            # Es el segundo registro
            $sql = "CALL registrar_entrada(?, ?, ?, ?, ?)";
        }

        $ps = $conexion->prepare($sql);
        $ps->bind_param("sssss", $_POST["proveedor"], $_POST["producto"], $_POST["talla"], $_POST["precio"], $_POST["stock"]);
        $ps->execute();

        $message = [
            "status" => true,
            "titulo" => "EXITO",
            "texto" => "Registro exitoso",
            "icono" => "success"
        ];
    } else {
        $message = [
            "status" => false,
            "titulo" => "CAMPOS VACIOS",
            "texto" => "Debes completar todo el formulario",
            "icono" => "warning"
        ];
    }

    print_r(json_encode($message, JSON_UNESCAPED_UNICODE));
}
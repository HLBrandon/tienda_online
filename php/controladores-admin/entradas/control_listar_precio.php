<?php

if (isset($_POST)) {

    if (!empty($_POST["proveedor_id"]) and !empty($_POST["producto_id"]) and !empty($_POST["talla_id"])) {

        include __DIR__ . "/../../../config/config.php";
        include __DIR__ . "/../../conexion.php";

        $sql = "SELECT tp.precio FROM entradas e
                INNER JOIN productos p
                ON e.producto_id = p.producto_id
                INNER JOIN tallas_productos tp
                ON p.producto_id = tp.producto_id
                WHERE e.proveedor_id = ? AND e.producto_id = ? AND e.talla_id = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sss", $_POST["proveedor_id"], $_POST["producto_id"], $_POST["talla_id"]);
        $stmt->execute();
        $rs = $stmt->get_result();

        if ($rs->num_rows > 0) {
            // ya hay en existencia
            $respuesta = $rs->fetch_object()->precio;
        } else {
            // no hay en existencia
            $respuesta = 0;
        }

        print_r($respuesta);
    }
}

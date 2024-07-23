<?php

$conexion = new mysqli(HOST, USER, PASS, DB_NAME, PORT);

if ($conexion->connect_error) {
    print_r("Error de conexion: " . $conexion->connect_error);
    exit;
}
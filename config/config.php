<?php
session_start();

#Zona horaria
date_default_timezone_set('America/Mexico_City');

#Ruta raiz
define('URL_RAIZ', '/tienda_online/');

#informacion de conexion
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB_NAME', 'tienda_online');
define('PORT', '3306');

#URL DE LA PAGINA DONDE TE ENCUENTRES
$url = $_SERVER['REQUEST_URI'];
#convierte en un arreglo la url
$titulo = explode("/", $url);

define('MONEDA', ' MXN');
define('PESO', '$ ');

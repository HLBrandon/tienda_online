<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php titulo($titulo[4]) ?></title>
    <?php
    $sql = "SELECT img_logo FROM sucursales WHERE sucursal_id = 1 LIMIT 1";
    $stmt = $conexion->query($sql);
    if ($dato = $stmt->fetch_object()) : ?>
        <link rel="shortcut icon" href="<?= URL_RAIZ . $dato->img_logo ?>">
    <?php endif; ?>


    <link rel="stylesheet" href="<?= URL_RAIZ ?>plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css">

</head>

<?php

function titulo($variable)
{
    switch ($variable) {
        case 'home':
            echo "Home";
            break;
        case 'clientes':
            echo "Mis Clientes";
            break;
        case 'proveedores':
            echo "Mis Proveedores";
            break;
        case 'productos':
            echo "Lista de Productos";
            break;
        case 'stocks':
            echo "Existencias";
            break;
        case 'marcas':
            echo "Marcas";
            break;
        case 'categorias':
            echo "Categorias";
            break;
        case 'generos':
            echo "Generos";
            break;
        case 'tallas':
            echo "Tallas";
            break;
        case 'entradas':
            echo "Entradas de Mercancia";
            break;
        case 'ajustes':
            echo "Ajustes de Administración";
            break;
        case 'direcciones':
            echo "Direcciones";
            break;
        default:
            echo "No Encontrado";
            break;
    }
}

?>

<body class="bg-body-secondary">

    <header class="navbar sticky-top bg-primary flex-md-nowrap p-2 p-lg-4 shadow">
        <a class="navbar-brand text-white fw-bold col-md-3 col-lg-2 me-0 px-3 fs-6 d-flex align-items-center" href="<?= URL_RAIZ ?>view/dashboard/home/">
            <?php
            $sql = "SELECT nombre_sucursal, img_logo FROM sucursales WHERE sucursal_id = 1 LIMIT 1";
            $stmt = $conexion->query($sql);
            if ($dato = $stmt->fetch_object()) : ?>
                <img src="<?= URL_RAIZ . $dato->img_logo ?>" alt="Logo" width="30" class="d-inline-block align-text-top me-2">
                <span id="header-titulo"><?= $dato->nombre_sucursal; ?></span>
            <?php
            endif;
            ?>
        </a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link text-white px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                    <i class="bi bi-search"></i>
                </button>
            </li>
            <li class="nav-item text-nowrap">
                <button class="nav-link text-white px-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
            </li>
        </ul>

        <div id="navbarSearch" class="navbar-search w-100 collapse">
            <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sider-titulo">
                            <?php
                            $sql = "SELECT nombre_sucursal FROM sucursales WHERE 1";
                            $stmt = $conexion->query($sql);
                            if ($dato = $stmt->fetch_object()) {
                                echo $dato->nombre_sucursal;
                            }
                            ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'home') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" aria-current="page" href="<?= URL_RAIZ ?>view/dashboard/home/">
                                    <i class="bi bi-house-fill me-2 h3"></i>Inicio
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'clientes') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/clientes/">
                                    <i class="bi bi-people-fill me-2 h3"></i>Clientes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'proveedores') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/proveedores/">
                                    <i class="bi bi-person-lines-fill me-2 h3"></i>Proveedores
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-uppercase">
                            <span>Productos</span>
                        </h6>
                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'productos') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/productos/">
                                    <i class="bi bi-box-seam-fill me-2 h4"></i>Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'stocks') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/stocks/">
                                    <i class="bi bi-boxes me-2 h4"></i>Stock de Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'marcas') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/marcas/">
                                    <i class="bi bi-alphabet-uppercase me-2 h4"></i>Marcas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'categorias') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/categorias/">
                                    <i class="bi bi-inboxes-fill me-2 h4"></i>Categorias
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'generos') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/generos/">
                                    <i class="bi bi-gender-ambiguous me-2 h4"></i>Generos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'tallas') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/tallas/">
                                    <i class="bi bi-columns-gap me-2 h4"></i>Tallas
                                </a>
                            </li>
                        </ul>

                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 bg-body-tertiary text-uppercase">
                            <span>Entradas</span>
                        </h6>

                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'entradas') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/entradas/">
                                    <i class="bi bi-clipboard2-plus-fill me-2 h3"></i>Entradas de Productos
                                </a>
                            </li>
                        </ul>

                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'direcciones') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/direcciones/">
                                    <i class="bi bi-geo-alt-fill me-2 h3"></i>Direcciones
                                </a>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 <?= (strpos($url, 'ajustes') !== false) ? "bg-primary text-white fw-bold rounded-end-5" : "" ?>" href="<?= URL_RAIZ ?>view/dashboard/ajustes/">
                                    <i class="bi bi-gear-fill me-2 h3"></i>Ajustes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="<?= URL_RAIZ ?>view/dashboard/logout/">
                                    <i class="bi bi-box-arrow-left me-2 h3"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 bg-body-secondary">
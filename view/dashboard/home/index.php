<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Panel de Administración</h2>
</div>

<div class="row">

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-primary shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-primary">
                            <a class="link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/clientes/">Clientes</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(usuario_id) as dato FROM usuarios WHERE rol_id = 2";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> personas</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary border-start border-2">
                        <i class="bi bi-people-fill h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-success shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title">
                            <a class="text-success link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/proveedores/">Proveedores</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(proveedor_id) as dato FROM proveedores";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> personas</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-person-lines-fill h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-danger shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-danger">
                            <a class="text-danger link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/productos/">Productos</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(producto_id) as dato FROM productos";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> productos</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-box-seam-fill h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-warning shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-warning">
                            <a class="text-warning link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/stocks/">Stock Total</a>
                        </h3>
                        <?php

                        $sql = "SELECT SUM(stock) as dato FROM tallas_productos";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= ($row->dato != null)? $row->dato : 0 ?> unidades</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-boxes h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-info shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-info">
                            <a class="text-info link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/marcas/">Marcas</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(marca_id) as dato FROM marcas";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> marcas</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-alphabet-uppercase h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-dark shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-dark">
                            <a class="text-dark link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/categorias/">Categorias</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(categoria_id) as dato FROM categorias";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> Cat</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-inboxes-fill h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-primary shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-primary">
                            <a class="link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/generos/">Generos</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(genero_id) as dato FROM generos";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> generos</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-gender-ambiguous h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="bg-white p-4 rounded-2 border-start border-4 border-success shadow-sm">
            <div class="card-body">
                <div class="row d-flex align-items-center">
                    <div class="col">
                        <h3 class="card-title text-success">
                            <a class="text-success link-underline link-underline-opacity-0" href="<?= URL_RAIZ ?>view/dashboard/tallas/">Tallas</a>
                        </h3>
                        <?php

                        $sql = "SELECT COUNT(talla_id) as dato FROM tallas";
                        $resultado = $conexion->query($sql);
                        if ($row = $resultado->fetch_object()) :
                        ?>
                            <p class="card-text"><?= $row->dato ?> medidas</p>
                        <?php endif ?>
                    </div>
                    <div class="col-auto text-center text-body-tertiary">
                        <i class="bi bi-columns-gap h1"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>

<?php include '../components/footer.php';
$conexion->close(); ?>
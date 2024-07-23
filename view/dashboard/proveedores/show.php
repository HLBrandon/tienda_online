<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$proveedor = (isset($_GET["proveedor"])) ? $_GET["proveedor"] : "";

if ($proveedor == "") {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h1 class="h2">Detalles del Proveedor</h1>
</div>

<div class="row g-3">

    <?php

    $sql = "SELECT * FROM proveedores WHERE proveedor_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $proveedor);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($dato = $resultado->fetch_object()) :
    ?>
        <div class="col-sm-6">
            <label class="form-label" for="">Nombre Completo</label>
            <input readonly value="<?= $dato->nombre_proveedor ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="nombre" id="nombre">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Direccón</label>
            <input readonly value="<?= $dato->direccion ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="direccion" id="direccion">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Correo Electrónico</label>
            <input readonly value="<?= $dato->correo ?>" required class="form-control form-control-lg rounded-0 border-3" type="email" name="correo" id="correo">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Número de Contacto</label>
            <input readonly value="<?= $dato->telefono ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="telefono" id="telefono">
        </div>
    <?php endif; ?>

    <div class="mb-5">
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/proveedores/">Volver</a>
    </div>
</div>

<?php include '../components/footer.php'; ?>
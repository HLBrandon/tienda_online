<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$proveedor = (isset($_GET["proveedor"])) ? $_GET["proveedor"] : "";
$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$token_tmp = md5($proveedor);

if ($proveedor == "" || $token == "" || $token != $token_tmp) {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h1 class="h2">Modificar Proveedor</h1>
</div>

<form class="row g-3" method="post" autocomplete="off" id="formulario">

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
            <input value="<?= $dato->nombre_proveedor ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="nombre" id="nombre">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Direccón</label>
            <input value="<?= $dato->direccion ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="direccion" id="direccion">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Correo Electrónico</label>
            <input value="<?= $dato->correo ?>" required class="form-control form-control-lg rounded-0 border-3" type="email" name="correo" id="correo">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="">Número de Contacto</label>
            <input value="<?= $dato->telefono ?>" required class="form-control form-control-lg rounded-0 border-3" type="text" name="telefono" id="telefono">
        </div>
    <?php endif; ?>

    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardar Cambios</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/proveedores/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {

        let params = new URLSearchParams(location.search);
        const datos = {
            "proveedor": params.get('proveedor'),
            "token": params.get('token')
        };

        $('#formulario').submit(function(e) {
            e.preventDefault();
            var formulario = new FormData(this);
            formulario.append('proveedor', datos.proveedor);
            formulario.append('token', datos.token);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/proveedor/control_update_proveedor.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    Swal.fire({
                        icon: data.icono,
                        title: data.mensaje,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });

    });
</script>
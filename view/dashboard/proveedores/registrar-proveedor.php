<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nuevo Proveedor</h1>
</div>

<form class="row g-3" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="nombre">Nombre Completo</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="nombre" id="nombre" placeholder="Nombre...">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="direccion">Dirección</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="direccion" id="direccion" placeholder="Dirección...">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="correo">Correo Electrónico (Opcional)</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="email" name="correo" id="correo" placeholder="proveedor@email.com">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="telefono">Telefono</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="tel" name="telefono" id="telefono" placeholder="Número de contacto">
    </div>

    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Proveedor</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/proveedores/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $("#formulario").submit(function(e) {
        e.preventDefault();
        var formulario = new FormData(this);
        
        $.ajax({
            type: "POST",
            url: "<?= URL_RAIZ ?>php/controladores-admin/proveedor/control_registrar_proveedor.php",
            data: formulario,
            contentType: false,
            processData: false,
            success: function(response) {
                let data = JSON.parse(response);
                if (data.success) {

                    $('#formulario').trigger("reset");

                    Swal.fire({
                        icon: data.icono,
                        title: data.mensaje,
                        showConfirmButton: false,
                        timer: 3000
                    });

                }
            }
        });

    }); 
</script>
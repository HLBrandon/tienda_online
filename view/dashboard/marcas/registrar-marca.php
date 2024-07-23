<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nueva Marca</h1>
</div>

<form enctype="multipart/form-data" class="row g-3 d-flex align-items-center" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="marca">Marca</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="text" name="marca" id="marca" placeholder="Marca...">
    </div>
    <div class="mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Marca</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/marcas/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {
        $("#formulario").submit(function(e) {
            e.preventDefault();
            let formulario = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/marcas/control_registrar_marca.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    if (data.success) {
                        $('#formulario').trigger("reset");
                    }
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
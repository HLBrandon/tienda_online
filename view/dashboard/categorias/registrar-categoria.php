<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nueva Categoria</h1>
</div>

<form enctype="multipart/form-data" class="row g-3" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="categoria">Nombre Categoria de Ropa</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="text" name="categoria" id="categoria" placeholder="Categoria...">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="img">Imágen</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="file" name="img" id="img">
    </div>

    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Categoria</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/categorias/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {
        $("#formulario").submit(function(e) {
            e.preventDefault();
            let datos = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/categorias/control_registrar_categoria.php",
                data: datos,
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
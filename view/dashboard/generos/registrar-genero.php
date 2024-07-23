<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nuevo Genero</h1>
</div>

<form enctype="multipart/form-data" class="row g-3" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="genero">Nombre Genero de Ropa</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="text" name="genero" id="genero" placeholder="Genero...">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="img">Imágen</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="file" name="img" id="img">
    </div>

    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Genero</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/generos/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#formulario').submit(function(e) {
            e.preventDefault();
            var datos = new FormData(this);
            console.log(datos.get('img'));
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/generos/control_registrar_genero.php",
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
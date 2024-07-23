<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$genero = (isset($_GET["genero"])) ? $_GET["genero"] : "";
$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$token_tmp = md5($genero);

if ($genero == "" || $token == "" || $token != $token_tmp) {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}

?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Editar Genero</h1>
</div>

<form enctype="multipart/form-data" class="row g-3" method="post" autocomplete="off" id="formulario">
    <?php

    $sql = "SELECT * FROM generos WHERE genero_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $genero);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($dato = $resultado->fetch_object()) :
    ?>
        <div class="col-sm-3">
            <label class="form-label">Imagen Actual</label>
            <img class="shadow rounded-2" width="100%" src="<?= URL_RAIZ . $dato->img_genero ?>">
            <input hidden name="img_ruta" value="<?= $dato->img_genero ?>" type="text">
        </div>
        <div class="col-sm-9">
            <div class="mb-3">
                <label class="form-label" for="genero">Nombre Genero de Ropa</label>
                <input value="<?= $dato->genero ?>" class="form-control form-control-lg rounded-0 border-3" type="text" name="genero" id="genero" placeholder="Genero...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="img">Imágen</label>
                <input class="form-control form-control-lg rounded-0 border-3" type="file" name="img" id="img">
            </div>
            <div class="mb-5">
                <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardas cambios</button>
                <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/generos/">Volver</a>
            </div>
        </div>
    <?php endif; ?>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {

        let params = new URLSearchParams(location.search);

        $("#formulario").submit(function(e) {
            e.preventDefault();
            var datos = new FormData(this);
            datos.append('genero_id', params.get('genero'));
            datos.append('token', params.get('token'));
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/generos/control_update_genero.php",
                data: datos,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    if (data.success) {
                        $('#formulario').trigger("reset");
                        Swal.fire({
                            icon: data.icono,
                            title: data.mensaje,
                            text: data.texto
                        });
                    } else {
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
    });
</script>
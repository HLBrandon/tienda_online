<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$categoria = (isset($_GET["categoria"])) ? $_GET["categoria"] : "";
$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$token_tmp = md5($categoria);

if ($categoria == "" || $token == "" || $token != $token_tmp) {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}

?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Editar Categoria</h1>
</div>

<form enctype="multipart/form-data" class="row g-3" method="post" autocomplete="off" id="formulario">
    <?php

    $sql = "SELECT * FROM categorias WHERE categoria_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($dato = $resultado->fetch_object()) :
    ?>
        <div class="col-sm-3">
            <label class="form-label">Imagen Actual</label>
            <img class="shadow rounded-2" width="100%" src="<?= URL_RAIZ . $dato->img_categoria ?>">
            <input hidden name="img_ruta" value="<?= $dato->img_categoria ?>" type="text">
        </div>
        <div class="col-sm-9">
            <div class="mb-3">
                <label class="form-label" for="categoria">Nombre Categoria de Ropa</label>
                <input value="<?= $dato->categoria ?>" class="form-control form-control-lg rounded-0 border-3" type="text" name="categoria" id="categoria" placeholder="Categoria...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="img">Imágen</label>
                <input class="form-control form-control-lg rounded-0 border-3" type="file" name="img" id="img">
            </div>
            <div class="mb-5">
                <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardas cambios</button>
                <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/categorias/">Volver</a>
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
            let datos = new FormData(this);
            datos.append("categoria_id", params.get("categoria"));
            datos.append("token", params.get("token"));
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/categorias/control_update_categoria.php",
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
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$marca = (isset($_GET["marca"])) ? $_GET["marca"] : "";
$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$token_tmp = md5($marca);

if ($marca == "" || $token == "" || $token != $token_tmp) {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}

?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Editar Marca</h1>
</div>

<form enctype="multipart/form-data" class="row g-3 d-flex align-items-center" method="post" autocomplete="off" id="formulario">
    <?php
    $sql = "SELECT * FROM marcas WHERE marca_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $marca);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($dato = $resultado->fetch_object()) : ?>
        <div class="col-sm-6">
            <label class="form-label" for="marca">Marca</label>
            <input value="<?= $dato->marca ?>" class="form-control form-control-lg rounded-0 border-3" type="text" name="marca" id="marca" placeholder="Marca...">
        </div>
    <?php endif ?>

    <div class="mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardar cambios</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/marcas/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {

        var params = new URLSearchParams(location.search);

        $("#formulario").submit(function(e) {
            e.preventDefault();
            let formulario = new FormData(this);
            formulario.append("marca_id", params.get("marca"));
            formulario.append("token", params.get("token"));
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/marcas/control_update_marca.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    if (data.success) {
                        $('#formulario').trigger("reset");
                        $('#marca').val(data.marca);
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
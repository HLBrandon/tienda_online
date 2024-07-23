<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nuevo Producto</h1>
</div>

<form enctype="multipart/form-data" class="row g-3 d-flex align-items-center" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="producto">Producto</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="text" name="producto" id="producto" placeholder="Producto...">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="img">Imagen</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="file" name="img" id="img">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="categoria">Categoria</label>
        <select class="form-select form-select-lg rounded-0 border-3" name="categoria" id="categoria">
            <option>Seleccionar...</option>
            <?php
            $sql = "SELECT categoria_id, categoria FROM categorias";
            $stmt = $conexion->query($sql);
            while ($dato = $stmt->fetch_object()) : ?>
                <option value="<?= $dato->categoria_id ?>"><?= $dato->categoria ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="marca">Marca</label>
        <select class="form-select form-select-lg rounded-0 border-3" name="marca" id="marca">
            <option value="">Seleccionar...</option>
            <?php
            $sql = "SELECT marca_id, marca FROM marcas";
            $stmt = $conexion->query($sql);
            while ($dato = $stmt->fetch_object()) : ?>
                <option value="<?= $dato->marca_id ?>"><?= $dato->marca ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-sm-12">
        <div class="form-floating">
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="descripcion" style="height: 100px"></textarea>
            <label for="floatingTextarea2">Descripción del Producto...</label>
        </div>
    </div>
    <div class="col-sm-12">
        <label for="">Seleccionar genero (Minimo uno)</label>
        <div class="fs-5">
            <?php
            $sql = "SELECT genero_id, genero FROM generos";
            $stmt = $conexion->query($sql);
            while ($dato = $stmt->fetch_object()) : ?>
                <div class="form-check form-check-inline">
                    <input name="generos[]" class="form-check-input" type="checkbox" id="checkbox<?= $dato->genero_id ?>" value="<?= $dato->genero_id ?>">
                    <label class="form-check-label" for="checkbox<?= $dato->genero_id ?>"><?= $dato->genero ?></label>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="mb-5 text-end">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Producto</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/productos/">Volver</a>
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
                url: "<?= URL_RAIZ ?>php/controladores-admin/productos/control_registrar_producto.php",
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
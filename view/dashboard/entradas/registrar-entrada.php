<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Registrar Entrada</h1>
</div>

<form enctype="multipart/form-data" class="row g-3 d-flex align-items-center" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-4">
        <label class="form-label" for="proveedor">Seleccionar Proveedor:</label>
        <select class="form-select form-select-lg rounded-0 border-3" name="proveedor" id="proveedor">
            <option value="" selected>Seleccionar...</option>
            <?php $sql = $conexion->query("SELECT proveedor_id, nombre_proveedor FROM proveedores");
            while ($dato = $sql->fetch_object()) : ?>
                <option value="<?= $dato->proveedor_id ?>"><?= $dato->nombre_proveedor ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-sm-4">
        <label class="form-label" for="producto">Seleccionar Producto:</label>
        <select disabled class="form-select form-select-lg rounded-0 border-3" name="producto" id="producto">
            <option value="" selected>Seleccionar...</option>
            <?php $sql = $conexion->query("SELECT producto_id, nombre_producto FROM productos");
            while ($dato = $sql->fetch_object()) : ?>
                <option value="<?= $dato->producto_id ?>"><?= $dato->nombre_producto ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-sm-4">
        <label class="form-label" for="talla">Seleccionar Talla:</label>
        <select disabled class="form-select form-select-lg rounded-0 border-3" name="talla" id="talla">
            <option value="" selected>Seleccionar...</option>
            <?php $sql = $conexion->query("SELECT talla_id, medida_talla FROM tallas");
            while ($dato = $sql->fetch_object()) : ?>
                <option value="<?= $dato->talla_id ?>"><?= $dato->medida_talla ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="col-sm-4">
        <label class="form-label" for="precio">Precio:</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="number" name="precio" id="precio" placeholder="0.00">
    </div>

    <div class="col-sm-4">
        <label class="form-label" for="stock">Stock:</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="number" name="stock" id="stock">
    </div>

    <div class="mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Entrada</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/entradas/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>

    $(document).ready(function () {
        
        $("#proveedor").change(function (e) { 
            e.preventDefault();
            let value = $(this).val();
            if (value !== "") {
                $("#producto").removeAttr("disabled");
            } else {
                $("#producto").attr("disabled", true);
            }
        });

        $("#producto").change(function (e) { 
            e.preventDefault();
            let value = $(this).val();
            if (value !== "") {
                $("#talla").removeAttr("disabled");
            } else {
                $("#talla").attr("disabled", true);
            }
        });

        $("#talla").change(function (e) { 
            e.preventDefault();
            let datos = {
                "talla_id"    : $(this).val(),
                "producto_id" : $("#producto").val(),
                "proveedor_id": $("#proveedor").val()
            };
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/entradas/control_listar_precio.php",
                data: datos,
                success: function (response) {
                    $("#precio").val(response);
                }
            });
        });

        $("#formulario").submit(function (e) { 
            e.preventDefault();
            let formulario = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/entradas/control_registrar_entrada.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function (response) {
                    
                }
            });
        });

    });

</script>
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$producto = (isset($_GET["producto"])) ? $_GET["producto"] : "";
$focus = (isset($_GET["focus"])) ? $_GET["focus"] : "productos";

if ($producto == "") {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Detalles del Producto</h1>
</div>

<div class="row g-3">
    <?php
    $sql = "SELECT * FROM productos WHERE producto_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $producto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($pro = $resultado->fetch_object()) : ?>
        <div class="col-sm-6">
            <label class="form-label" for="producto">Producto</label>
            <input readonly value="<?= $pro->nombre_producto ?>" class="form-control form-control-lg rounded-0 border-3" type="text" name="producto" id="producto" placeholder="Producto...">
        </div>
        <div class="col-sm-6">
            <label class="form-label" for="categoria">Categoria</label>
            <select class="form-select form-select-lg rounded-0 border-3" name="categoria" id="categoria">
                <option>Seleccionar...</option>
                <?php
                $sql = "SELECT categoria_id, categoria FROM categorias";
                $stmt = $conexion->query($sql);
                while ($dato = $stmt->fetch_object()) : ?>
                    <option <?= ($pro->categoria_id == $dato->categoria_id) ? "selected" : "" ?> value="<?= $dato->categoria_id ?>"><?= $dato->categoria ?></option>
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
                    <option <?= ($pro->marca_id == $dato->marca_id) ? "selected" : "" ?> value="<?= $dato->marca_id ?>"><?= $dato->marca ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-sm-3">
            <label for="form-label">Imagen Actual:</label>
            <img src="<?= URL_RAIZ . $pro->img_producto ?>" class="img-fluid shadow" width="100%">
            <input hidden value="<?= $pro->img_producto ?>" type="text" name="img_ruta" id="img_ruta">
        </div>
        <div class="col-sm-9">
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="descripcion" style="height: 100px"><?= $pro->descripcion ?></textarea>
                <label for="floatingTextarea2">Descripción del Producto...</label>
            </div>
            <?php
            $arreglo = array();
            $sql = "SELECT genero_id FROM producto_genero WHERE producto_id = $producto";
            $stmt = $conexion->query($sql);

            while ($row = $stmt->fetch_object()) {
                $arreglo[] = $row->genero_id;
            }
            ?>
            <div class="mb-3">
                <label for="">Seleccionar genero (Minimo uno)</label>
                <div class="fs-5">
                    <?php
                    $sql = "SELECT genero_id, genero FROM generos";
                    $stmt = $conexion->query($sql);
                    while ($dato = $stmt->fetch_object()) : ?>
                        <div class="form-check form-check-inline">
                            <input <?= (in_array($dato->genero_id, $arreglo)) ? "checked" : "" ?> name="generos[]" class="form-check-input" type="checkbox" id="checkbox<?= $dato->genero_id ?>" value="<?= $dato->genero_id ?>">
                            <label class="form-check-label" for="checkbox<?= $dato->genero_id ?>"><?= $dato->genero ?></label>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="mb-5 text-end">
                <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardar Cambios</button>
                <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/<?= $focus ?>/">Volver</a>
            </div>

        </div>

    <?php endif ?>

</div>

<?php include '../components/footer.php'; ?>
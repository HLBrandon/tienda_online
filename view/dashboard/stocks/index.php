<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Stocks de Productos</h2>
</div>

<a class="btn btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/entradas/registrar-entrada.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>
<a class="btn btn-danger rounded-0" href="" title="Descargar PDF"><i class="bi bi-box-arrow-in-down me-2"></i>PDF</a>
<a class="btn btn-success rounded-0" href="" title="Descargar Xlsx"><i class="bi bi-box-arrow-in-down me-2"></i>EXCEL</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-pro-talla">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Medida</th>
                <th class="text-center">Precio unitario</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Total</th>
                <th class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody id="cuerpo_tabla_cliente" class="bg-white">
            <?php
            $sql = "SELECT id, tp.producto_id, nombre_producto, medida_talla, precio, stock FROM tallas_productos tp
                    INNER JOIN productos p ON tp.producto_id = p.producto_id
                    INNER JOIN tallas t ON tp.talla_id = t.talla_id
                    ORDER BY id";
            $resultado = $conexion->query($sql);

            while ($row = $resultado->fetch_object()) : ?>
                <tr>
                    <td class="text-center"><?= $row->id ?></td>
                    <td class="text-center">
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="<?= URL_RAIZ ?>view/dashboard/productos/show.php?producto=<?= $row->producto_id ?>"><?= $row->nombre_producto ?></a>
                    </td>
                    <td class="text-center"><?= $row->medida_talla ?></td>
                    <td class="text-center"><?= PESO . number_format($row->precio, 2) . MONEDA ?></td>
                    <td class="text-center"><?= $row->stock ?></td>
                    <td class="text-center"><?= PESO . number_format($row->precio * $row->stock, 2) . MONEDA ?></td>
                    <td class="text-center">

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>


<?php include '../components/footer.php';
$conexion->close(); ?>

<script>
    $(document).ready(function() {
        $('#tabla-pro-talla').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
        });
    });
</script>
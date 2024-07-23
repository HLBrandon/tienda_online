<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Entradas de Productos</h2>
</div>

<a class="btn btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/entradas/registrar-entrada.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>
<a class="btn btn-danger rounded-0" href="" title="Descargar PDF"><i class="bi bi-box-arrow-in-down me-2"></i>PDF</a>
<a class="btn btn-success rounded-0" href="" title="Descargar Xlsx"><i class="bi bi-box-arrow-in-down me-2"></i>EXCEL</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-producto">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th class="text-center">Fecha de ingreso</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Producto</th>
                <th class="text-center">Talla</th>
                <th class="text-center">Precio Unitario</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Total</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            $sql = "SELECT entrada_id, fecha_entrada, p.proveedor_id, nombre_proveedor, pro.producto_id, nombre_producto, medida_talla, e.precio, e.stock FROM entradas e
                    INNER JOIN proveedores p
                    ON e.proveedor_id = p.proveedor_id
                    INNER JOIN productos pro
                    ON e.producto_id = pro.producto_id
                    INNER JOIN tallas t
                    ON e.talla_id = t.talla_id";
            $resultado = $conexion->query($sql);

            while ($row = $resultado->fetch_object()) : ?>
                <tr>
                    <td class="text-center"><?= $row->fecha_entrada ?></td>
                    <td class="text-center">
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="<?= URL_RAIZ ?>view/dashboard/proveedores/show.php?proveedor=<?= $row->proveedor_id ?>"><?= $row->nombre_proveedor ?></a>
                    </td>
                    <td class="text-center">
                        <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="<?= URL_RAIZ ?>view/dashboard/productos/show.php?producto=<?= $row->producto_id ?>"><?= $row->nombre_producto ?></a>
                    </td>
                    <td class="text-center"><?= $row->medida_talla ?></td>
                    <td class="text-center"><?= number_format($row->precio, 2) . MONEDA ?></td>
                    <td class="text-center"><?= $row->stock ?></td>
                    <td class="text-center"><?= number_format($row->precio * $row->stock, 2) . MONEDA ?></td>
                    <td class="text-center text-uppercase">
                        <a class="btn btn-sm btn-outline-success rounded-0 mb-2 mb-lg-0" href="<?= URL_RAIZ ?>view/dashboard/marcas/editar-marca.php?marca=<?= $row->marca_id ?>&token=<?= md5($row->marca_id) ?>">Editar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#tabla-producto').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
        });
    });
</script>
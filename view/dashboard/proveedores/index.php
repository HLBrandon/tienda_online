<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Mis Proveedores</h2>
</div>

<a class="btn btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/proveedores/registrar-proveedor.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-proveedor">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th class="text-start">Teléfono</th>
                <th>Correo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            $sql = "SELECT * FROM proveedores";
            $resultado = $conexion->query($sql);

            while ($row = $resultado->fetch_object()) : ?>
                <tr>
                    <td><?= $row->nombre_proveedor ?></td>
                    <td><?= $row->direccion ?></td>
                    <td class="text-start"><?= $row->telefono ?></td>
                    <td><?= $row->correo ?></td>
                    <td class="text-uppercase">
                        <a class="btn btn-sm btn-outline-success rounded-0 mb-2 mb-lg-0" href="<?= URL_RAIZ ?>view/dashboard/proveedores/editar-proveedor.php?proveedor=<?= $row->proveedor_id ?>&token=<?= md5($row->proveedor_id) ?>">Editar</a>
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
        $('#tabla-proveedor').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
        });
    });
</script>
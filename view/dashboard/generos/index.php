<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Generos</h2>
</div>

<a class="btn btn-lg btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/generos/registrar-genero.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>
<a class="btn btn-lg btn-danger rounded-0" href="" title="Descargar PDF"><i class="bi bi-box-arrow-in-down me-2"></i>PDF</a>
<a class="btn btn-lg btn-success rounded-0" href="" title="Descargar Xlsx"><i class="bi bi-box-arrow-in-down me-2"></i>EXCEL</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-genero">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">Genero</th>
                <th class="text-center">Imagen</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpo_tabla_cliente" class="bg-white">
            <?php
            $sql = "SELECT * FROM generos";
            $resultado = $conexion->query($sql);

            while ($row = $resultado->fetch_object()) : ?>
                <tr>
                    <td class="text-center"><?= $row->genero_id ?></td>
                    <td class="text-center"><?= $row->genero ?></td>
                    <td class="text-center">
                        <img src="<?= URL_RAIZ . $row->img_genero ?>" width="10%">
                    </td>
                    <td class="text-center text-uppercase">
                        <a class="btn btn-sm btn-outline-success rounded-0 mb-2 mb-lg-0" href="<?= URL_RAIZ ?>view/dashboard/generos/editar-genero.php?genero=<?= $row->genero_id ?>&token=<?= md5($row->genero_id) ?>">Editar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../components/footer.php'; ?>



<script>
    $(document).ready(function() {
        $('#tabla-genero').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
            },
        });
    });
</script>
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Mis Clientes</h2>
</div>

<a class="btn btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/clientes/registrar-cliente.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>
<a class="btn btn-danger rounded-0" href="<?= URL_RAIZ ?>view/dashboard/clientes/generar-pdf.php" title="Descargar PDF"><i class="bi bi-box-arrow-in-down me-2"></i>PDF</a>
<a class="btn btn-success rounded-0" href="" title="Descargar Xlsx"><i class="bi bi-box-arrow-in-down me-2"></i>EXCEL</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-cliente">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th class="text-start">Fecha Registro</th>
                <th>Ultimo acceso</th>
                <th>Acceso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpo_tabla_cliente" class="bg-white">
            <?php
            $sql = "SELECT usuario_id, nombre, apellidos, correo, fecha_registro, ultimo_acceso, acceso FROM usuarios
                    WHERE rol_id = 2";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) :
            ?>
                <?php while ($row = $resultado->fetch_object()) : ?>
                    <tr>
                        <td><?= $row->nombre ?> <?= $row->apellidos ?></td>
                        <td><?= $row->correo ?></td>
                        <td class="text-start"><?= $row->fecha_registro ?></td>
                        <td><?= $row->ultimo_acceso ?></td>
                        <td><?= ($row->acceso == 0) ? '<span class="badge text-bg-danger">Sin Acceso</span>' : '<span class="badge text-bg-success">Con Acceso</span>' ?></td>
                        <td class="text-uppercase">
                            <a class="btn btn-sm btn-outline-primary rounded-0 mb-2 mb-lg-0" href="">Ver</a>
                            <a class="btn btn-sm btn-outline-success rounded-0 mb-2 mb-lg-0" href="<?= URL_RAIZ ?>view/dashboard/clientes/editar-cliente.php?cliente=<?= $row->usuario_id ?>&token=<?= md5($row->usuario_id) ?>">Editar</a>
                            <?php if ($row->acceso == 1) : ?>
                                <button onclick="quitar_acceso(<?= $row->usuario_id ?>)" class="btn btn-sm btn-outline-danger rounded-0">Quitar Acceso</button>
                            <?php else : ?>
                                <button onclick="dar_acceso(<?= $row->usuario_id ?>)" class="btn btn-sm btn-outline-success rounded-0">Dar Acceso</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="6">No hay registros</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../components/footer.php'; ?>



<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('#tabla-cliente').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json',
                },
            });
        });
    });

    function quitar_acceso(usuario_id) {
        Swal.fire({
            title: "Quitar acceso",
            text: "Este cliente perdera el acceso a su cuenta",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF0000",
            cancelButtonColor: "#555555",
            confirmButtonText: "Sí, Quitar Acceso",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "<?= URL_RAIZ ?>php/controladores-admin/quitar_acceso_cliente.php",
                    data: {
                        usuario_id
                    },
                    success: function(response) {
                        let data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Acceso denegado",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1800);
                        }
                    }
                });
            }
        });
    }

    function dar_acceso(usuario_id) {
        Swal.fire({
            title: "Dar acceso",
            text: "Este cliente recuperará el acceso a su cuenta",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00A600",
            cancelButtonColor: "#555555",
            confirmButtonText: "Sí, Dar Acceso",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "POST",
                    url: "<?= URL_RAIZ ?>php/controladores-admin/dar_acceso_cliente.php",
                    data: {
                        usuario_id
                    },
                    success: function(response) {
                        let data = JSON.parse(response);
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Acceso recuperado",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1800);
                        }
                    }
                });
            }
        });
    }
</script>
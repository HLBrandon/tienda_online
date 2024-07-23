<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Lista de Productos</h2>
</div>

<a class="btn btn-primary rounded-0" href="<?= URL_RAIZ ?>view/dashboard/productos/registrar-producto.php"><i class="bi bi-plus-circle me-2"></i>Nuevo</a>
<a class="btn btn-danger rounded-0" href="" title="Descargar PDF"><i class="bi bi-box-arrow-in-down me-2"></i>PDF</a>
<a class="btn btn-success rounded-0" href="" title="Descargar Xlsx"><i class="bi bi-box-arrow-in-down me-2"></i>EXCEL</a>

<div class="table-responsive mt-2 mb-5">
    <table class="table table-striped shadow" id="tabla-producto">
        <thead class="text-bg-primary text-uppercase">
            <tr>
                <th class="text-center">Producto</th>
                <th class="text-center">Imagen</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Marca</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Genero</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpo_tabla_cliente" class="bg-white">
            <?php
            $sql = "SELECT producto_id, nombre_producto, img_producto, descripcion, m.marca, c.categoria FROM productos P 
                    INNER JOIN marcas m
                    ON p.marca_id = m.marca_id
                    INNER JOIN categorias c
                    ON p.categoria_id = c.categoria_id";
            $resultado = $conexion->query($sql);

            while ($row = $resultado->fetch_object()) : ?>
                <tr>
                    <td class="text-center"><?= $row->nombre_producto ?></td>
                    <td class="text-center">
                        <img src="<?= URL_RAIZ . $row->img_producto ?>" class="img-fluid" width="20%">
                    </td>
                    <td class="text-center"><?= $row->descripcion ?></td>
                    <td class="text-center"><?= $row->marca ?></td>
                    <td class="text-center"><?= $row->categoria ?></td>
                    <td class="text-center">
                        <?php
                        $sql_tmp = "SELECT genero FROM generos g
                                INNER JOIN producto_genero pg
                                ON g.genero_id = pg.genero_id
                                WHERE pg.producto_id = $row->producto_id";
                        $resultado_tmp = $conexion->query($sql_tmp);

                        $contador = 1;

                        while ($row_tmp = $resultado_tmp -> fetch_object()) {
                            if ($contador == $resultado_tmp->num_rows) {
                                echo $row_tmp -> genero;
                            } else {
                                echo $row_tmp -> genero . ", ";
                            }
                            $contador++;
                        }

                        ?>
                    </td>
                    <td class="text-center text-uppercase">
                        <a class="btn btn-sm btn-outline-success rounded-0 mb-2 mb-lg-0" href="<?= URL_RAIZ ?>view/dashboard/productos/editar-producto.php?producto=<?= $row->producto_id ?>&token=<?= md5($row->producto_id) ?>">Editar</a>
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
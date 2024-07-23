<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h2>Nuevo Cliente</h1>
</div>

<form class="row g-3" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="">Nombre</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="nombre" id="nombre" placeholder="Nombre">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Apellidos</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Correo Electrónico</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="email" name="correo" id="correo" placeholder="you@email.com">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Contraseña</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="password" name="clave" id="clave" placeholder="Contraseña">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Calle</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="calle" id="calle" placeholder="Calle">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Número exterior</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="num_ex" id="num_ex" placeholder="Número extierior">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Número interior (Opcional)</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="num_in" id="num_in" placeholder="Número interior">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Código Postal</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="codigo_postal" id="codigo_postal" placeholder="CP">
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Estado</label>
        <select required class="form-select form-select-lg rounded-0 border-3" name="estado" id="estado">
            <option value="" selected>Seleccionar</option>
            <?php
            $sql = "SELECT * FROM estados";
            $stmt = $conexion->query($sql);
            while ($row = $stmt->fetch_object()) :
            ?>
                <option value="<?= $row->estado_id ?>"><?= $row->nombre_estado ?></option>
            <?php endwhile;
            $stmt->free_result();
            $conexion->close(); ?>
        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Municipio</label>
        <select required disabled class="form-select form-select-lg rounded-0 border-3" name="municipio" id="municipio">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Ciudad</label>
        <select required disabled class="form-select form-select-lg rounded-0 border-3" name="ciudad" id="ciudad">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Colonia</label>
        <select required disabled class="form-select form-select-lg rounded-0 border-3" name="colonia" id="colonia">

        </select>
    </div>
    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Registrar Cliente</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/clientes/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {

        listar_municipio();
        listar_ciudad();
        listar_colonia();

        function listar_municipio(valor) {
            let estado_id = valor;
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/listar_municipio.php",
                data: {
                    "estado_id": estado_id
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    let temp = `<option value="" selected>Seleccionar</option>`;
                    data.forEach(element => {
                        temp += `<option value="${element["municipio_id"]}">${element["nombre_municipio"]}</option>`;
                    });
                    $('#municipio').html(temp);
                }
            });
        }

        $(document).on('change', '#estado', function(e) {
            e.preventDefault();
            var valor = $(this).val();
            if (valor != "") {
                listar_municipio(valor);
            } else {
                listar_municipio();
            }
            $('#municipio').removeAttr('disabled');
        });

        function listar_ciudad(valor) {
            let municipio_id = valor;
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/listar_ciudad.php",
                data: {
                    'municipio_id': municipio_id
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    let temp = `<option value="" selected>Seleccionar</option>`;
                    data.forEach(element => {
                        temp += `<option value="${element["ciudad_id"]}">${element["nombre_ciudad"]}</option>`;
                    });
                    $('#ciudad').html(temp);
                }
            });
        }

        $(document).on('change', '#municipio', function(e) {
            e.preventDefault();
            var valor = $(this).val();
            if (valor != "") {
                listar_ciudad(valor);
            } else {
                listar_ciudad();
            }
            $('#ciudad').removeAttr('disabled');
        });

        function listar_colonia(valor) {
            let ciudad_id = valor;
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/listar_colonia.php",
                data: {
                    'ciudad_id': ciudad_id
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    let temp = `<option value="" selected>Seleccionar</option>`;
                    data.forEach(element => {
                        temp += `<option value="${element["colonia_id"]}">${element["nombre_colonia"]}</option>`;
                    });
                    $('#colonia').html(temp);
                }
            });
        }

        $(document).on('change', '#ciudad', function(e) {
            e.preventDefault();
            var valor = $(this).val();
            if (valor != "") {
                listar_colonia(valor);
            } else {
                listar_colonia();
            }
            $('#colonia').removeAttr('disabled');
        });

        $("#formulario").submit(function(e) {
            e.preventDefault();
            var formulario = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/control_registrar_cliente.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    if (data.success) {
                        $('#formulario').trigger("reset");
                        $('#colonia, #ciudad, #municipio').prop('disabled', true);
                        Swal.fire({
                            icon: "success",
                            title: "Acceso denegado",
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
            });
        });

    });
</script>
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';

$cliente = (isset($_GET["cliente"])) ? $_GET["cliente"] : "";
$token = (isset($_GET["token"])) ? $_GET["token"] : "";
$token_tmp = md5($cliente);

if ($cliente == "" || $token == "" || $token != $token_tmp) {
    print_r("Oh no! Ha ocurrido un error inesperado");
    exit;
}
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h1 class="h2">Modificar Cliente</h1>
</div>

<form class="row g-3" method="post" autocomplete="off" id="formulario">
    <div class="col-sm-6">
        <label class="form-label" for="">Nombre</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="nombre" id="nombre">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Apellidos</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="apellidos" id="apellidos">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Correo Electrónico</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="email" name="correo" id="correo">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Calle</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="text" name="calle" id="calle">
    </div>
    <div class="col-sm-4">
        <label class="form-label" for="">Número exterior</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="num_ex" id="num_ex">
    </div>
    <div class="col-sm-4">
        <label class="form-label" for="">Número interior (Opcional)</label>
        <input class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="num_in" id="num_in">
    </div>
    <div class="col-sm-4">
        <label class="form-label" for="">Código Postal</label>
        <input required class="form-control form-control-lg rounded-0 border-3" type="number" min="1" name="codigo_postal" id="codigo_postal">
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
        <select required class="form-select form-select-lg rounded-0 border-3" name="municipio" id="municipio">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Ciudad</label>
        <select required class="form-select form-select-lg rounded-0 border-3" name="ciudad" id="ciudad">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Colonia</label>
        <select required class="form-select form-select-lg rounded-0 border-3" name="colonia" id="colonia">

        </select>
    </div>
    <div class="text-end mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardar Cambios</button>
        <a class="btn btn-lg btn-secondary rounded-0 border-3 text-uppercase" href="<?= URL_RAIZ ?>view/dashboard/clientes/">Volver</a>
    </div>
</form>

<?php include '../components/footer.php'; ?>

<script>
    $(document).ready(function() {

        let params = new URLSearchParams(location.search);
        const datos = {
            "cliente": params.get('cliente'),
            "token": params.get('token')
        };

        listar_municipio();
        listar_ciudad();
        listar_colonia();
        listar();

        $('#formulario').submit(function(e) {
            e.preventDefault();
            var formulario = new FormData(this);
            formulario.append('cliente', datos.cliente);
            formulario.append('token', datos.token);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/control_update_cliente.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    let data = JSON.parse(response);
                    Swal.fire({
                        icon: data.icono,
                        title: data.mensaje,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });


        function listar() {
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/edit-cliente.php",
                data: datos,
                success: function(response) {
                    let data = JSON.parse(response);
                    $("#nombre").val(data.nombre);
                    $("#apellidos").val(data.apellidos);
                    $("#correo").val(data.correo);
                    $("#calle").val(data.calle);
                    $("#num_ex").val(data.num_ex);
                    $("#num_in").val(data.num_in);
                    $("#codigo_postal").val(data.codigo_postal);

                    $("#estado").val(data.estado_id);
                    $("#municipio").val(data.municipio_id);
                    $("#ciudad").val(data.ciudad_id);
                    $("#colonia").val(data.colonia_id);
                }
            });
        }

        function listar_municipio(params) {
            var estado_id = params;
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/listar_municipio.php",
                data: {
                    estado_id
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

    });
</script>
<?php
include '../../../config/config.php';
include '../../../php/conexion.php';
?>

<?php include '../components/hearder.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 mt-3 mb-5 border-bottom bg-white shadow-sm">
    <h2>Ajustes de Administración</h2>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h5>Información del Administrador</h5>
</div>

<form class="row g-3" method="post" autocomplete="off" id="form_admin">
    <div class="col-sm-6">
        <label class="form-label" for="">Nombre</label>
        <input required class="form-control rounded-0 border-3" type="text" name="nombre" id="nombre" placeholder="Nombre">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Apellidos</label>
        <input required class="form-control rounded-0 border-3" type="text" name="apellidos" id="apellidos" placeholder="Apellidos">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Correo Electrónico</label>
        <input required class="form-control rounded-0 border-3" type="email" name="correo" id="correo" placeholder="you@email.com">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Contraseña (Opcional)</label>
        <input required class="form-control rounded-0 border-3" type="password" name="clave" id="clave" placeholder="Contraseña">
    </div>
    <div class="col-sm-6">
        <label class="form-label" for="">Calle</label>
        <input required class="form-control rounded-0 border-3" type="text" name="calle" id="calle" placeholder="Calle">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Número exterior</label>
        <input required class="form-control rounded-0 border-3" type="number" min="1" name="num_ex" id="num_ex" placeholder="Número extierior">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Número interior (Opcional)</label>
        <input class="form-control rounded-0 border-3" type="number" min="1" name="num_in" id="num_in" placeholder="Número interior">
    </div>
    <div class="col-sm-2">
        <label class="form-label" for="">Código Postal</label>
        <input required class="form-control rounded-0 border-3" type="number" min="1" name="codigo_postal" id="codigo_postal" placeholder="CP">
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Estado</label>
        <select required class="form-select rounded-0 border-3" name="estado" id="estado">
            <option value="" selected>Seleccionar</option>
        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Municipio</label>
        <select required disabled class="form-select rounded-0 border-3" name="municipio" id="municipio">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Ciudad</label>
        <select required disabled class="form-select rounded-0 border-3" name="ciudad" id="ciudad">

        </select>
    </div>
    <div class="col-sm-3">
        <label class="form-label" for="">Colonia</label>
        <select required disabled class="form-select rounded-0 border-3" name="colonia" id="colonia">

        </select>
    </div>
    <div class="mb-5">
        <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardar Cambios</button>
    </div>
</form>


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center p-3 my-3 border-bottom bg-white shadow-sm">
    <h5>Información de la Empresa</h5>
</div>

<form enctype="multipart/form-data" class="row g-3 mb-5" method="post" autocomplete="off" id="form_empresa">
    <?php

    $sql = "SELECT * FROM sucursales WHERE 1";
    $resultado = $conexion->query($sql);
    if ($dato = $resultado->fetch_object()) :
    ?>
        <div class="col-sm-3">
            <label class="form-label">Logo Actual</label>
            <img class="mb-2" width="100%" src="<?= URL_RAIZ . $dato->img_logo ?>" id="imgPreview">
            <div class="mb-3">
                <label class="btn btn-outline-primary form-control" for="img">Seleccionar Nuevo Logo</label>
                <span>Imagen: JPEG, JPG, PNG. Tipo 1:1</span>
                <input hidden class="form-control rounded-0 border-3" type="file" name="img" id="img" accept="image/*" onchange="previewImage(event, '#imgPreview')">
                <input hidden type="text" name="img_ruta" id="img_ruta" value="<?= $dato->img_logo ?>">
            </div>
        </div>
        <div class="col-sm-9">
            <div class="mb-3">
                <label class="form-label" for="nombre_sucursal">Nombre de la Empresa</label>
                <input value="<?= $dato->nombre_sucursal ?>" class="form-control rounded-0 border-3" type="text" name="nombre_sucursal" id="nombre_sucursal" placeholder="Nombre de la Empresa...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="direccion_sucursal">Dirección</label>
                <input value="<?= $dato->direccion ?>" class="form-control rounded-0 border-3" type="text" name="direccion_sucursal" id="direccion_sucursal" placeholder="Dirección...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="cif_sucursal">Cédula de Identificación Oficial</label>
                <input value="<?= $dato->cif ?>" class="form-control rounded-0 border-3" type="text" name="cif_sucursal" id="cif_sucursal" placeholder="CIF...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefono_sucursal">Telefono de contacto</label>
                <input value="<?= $dato->telefono ?>" class="form-control rounded-0 border-3" type="tel" name="telefono_sucursal" id="telefono_sucursal" placeholder="Telefono...">
            </div>
            <div class="mb-3">
                <label class="form-label" for="correo_sucursal">Correo electrónico</label>
                <input value="<?= $dato->correo ?>" class="form-control rounded-0 border-3" type="email" name="correo_sucursal" id="correo_sucursal" placeholder="Correo...">
            </div>
            <div class="mb-5">
                <button class="btn btn-lg btn-success rounded-0 border-3 text-uppercase" type="submit">Guardas cambios</button>
            </div>
        </div>
    <?php endif; ?>
</form>


<?php include '../components/footer.php';
$conexion->close(); ?>

<script>
    $(document).ready(function() {
        $("#form_empresa").submit(function(e) {
            e.preventDefault();
            let formulario = new FormData(this);
            $.ajax({
                type: "POST",
                url: "<?= URL_RAIZ ?>php/controladores-admin/sucursal/editar-info-sucursal.php",
                data: formulario,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (!response.error) {
                        let data = JSON.parse(response);
                        $("#sider-titulo, #header-titulo").html(data.sucursal);
                        Swal.fire({
                            icon: data.icono,
                            title: data.titulo,
                            text: data.mensaje,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }
                }
            });
        });
    });

    function previewImage(event, querySelector) {
        // Recuperamos el input que desencadenó la acción
        const input = event.target;
        // Recuperamos la etiqueta img donde cargaremos la imagen
        $imgPreview = document.querySelector(querySelector);
        // Verificamos si existe una imagen seleccionada
        if (!input.files.length) return;
        // Recuperamos el archivo subido
        file = input.files[0];
        // Creamos la URL del objeto
        objectURL = URL.createObjectURL(file);
        // Modificamos el atributo src de la etiqueta img
        $imgPreview.src = objectURL;
    }
</script>
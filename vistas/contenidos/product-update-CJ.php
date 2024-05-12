<?php
if ($_SESSION['privilegio_sdp'] < 1 || $_SESSION['privilegio_sdp'] > 2) {
    echo $lc->forzar_cierre_sesion_controlador();
    exit();
}
?>
<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-center">
        <i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR PRODUCTO
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVER_URL; ?>product-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PRODUCTO</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>product-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PRODUCTOS</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>product-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PRODUCTO</a>
        </li>
    </ul>
</div>

<!--CONTENT-->
<div class="container-fluid">
    <?php
    require_once "./controladores/productoControlador.php";
    $ins_producto = new productoControlador();

    $datos_producto = $ins_producto->datos_producto_controlador("Unico", $pagina[1]);

    if ($datos_producto->rowCount() == 1) {
        $campos = $datos_producto->fetch();

    ?>
		<form  class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/productoAjax.php" method="POST" data-form="update" autocomplete="off">
		<input type="hidden" name="id_producto_up" value="<?php echo $pagina[1] ?>">

            <fieldset>
                <legend class="text-center"><i class="far fa-plus-square"></i> &nbsp; Información del Producto</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="form-group">
                                <label for="producto_codigo" class="bmd-label-floating">Códido</label>
                                <input type="text" pattern="[A-Z0-9]{3,6}" class="form-control" name="producto_codigo_up" id="producto_codigo" maxlength="6" value="<?php echo $campos['codigo_producto']?>" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-9">
                            <div class="form-group">
                                <label for="producto_nombre" class="bmd-label-floating">Nombre del producto</label>
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{14,100}" class="form-control" name="producto_nombre_up" id="producto_nombre" maxlength="100" value="<?php echo $campos['nombre_producto']?>" required >
                            </div>
                        </div>

                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="producto_detalle" class="bmd-label-floating">Descripción </label>
                                <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{1,190}" class="form-control" name="producto_detalle_up" id="producto_detalle" maxlength="190" value="<?php echo $campos['descripcion_producto']?>" required >
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
            </p>
        </form>
    <?php
    } else {
    ?>
        <div class="alert alert-danger text-center" role="alert">
            <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
            <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
            <p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
        </div>
    <?php
    }
    ?>
</div>
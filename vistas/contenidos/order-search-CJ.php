<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a href="<?php echo SERVER_URL; ?>order-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PEDIDO</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>pending-order-list/"><i class="fas fa-hourglass-half"></i> &nbsp; PEDIDOS PENDIENTES</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>placed-order-list/"><i class="fas fa-clipboard-check"></i> &nbsp; PEDIDOS REALIZADOS</a>
        </li>
        <li>
            <a class="active" href="<?php echo SERVER_URL; ?>order-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO</a>
        </li>
    </ul>
</div>
<?php
if (!isset($_SESSION['fecha_creacion_pedido']) && empty($_SESSION['fecha_creacion_pedido'])) {
?>
    <div class="container-fluid">
        <form class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
            <input type="hidden" name="modulo" value="pedido">

            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="busqueda_creacion_pedido">Fecha de creacion (día/mes/año)</label>
                            <input type="date" class="form-control" name="fecha_creacion" id="busqueda_creacion_pedido" maxlength="30">
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 40px;">
                            <button type="submit" class="btn btn-raised btn-info"><i class="fas fa-search"></i> &nbsp; BUSCAR</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
} else {
?>

    <div class="container-fluid">
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/buscadorAjax.php" method="POST" data-form="search" autocomplete="off">
            <input type="hidden" name="modulo" value="pedido">
            <input type="hidden" name="eliminar_busqueda" value="eliminar">
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-6">
                        <p class="text-center" style="font-size: 20px;">
                            Fecha de busqueda: <?php echo $_SESSION['fecha_creacion_pedido'] ?> <strong> </strong>
                        </p>
                    </div>
                    <div class="col-12">
                        <p class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-raised btn-danger"><i class="far fa-trash-alt"></i> &nbsp; ELIMINAR BÚSQUEDA</button>
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>


    <div class="container-fluid">
        <?php

        require_once "./controladores/pedidoControlador.php";
        $ins_pedidoTab = new pedidoControlador();

        echo $ins_pedidoTab->paginador_pedido_controlador($pagina[1], 8, $_SESSION['privilegio_sdp'], $pagina[0], "Busquedad", $_SESSION['fecha_creacion_pedido']);


        ?>
    </div>
<?php } ?>
<?php
if ($_SESSION['privilegio_sdp'] < 1 || $_SESSION['privilegio_sdp'] > 2) {
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}
?>
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; ACTUALIZAR PEDIDO
    </h3>
    <p class="text-justify">

    </p>
</div>

<div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a   href="<?php echo SERVER_URL; ?>order-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PEDIDO</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVER_URL; ?>pending-order-list/"><i class="fas fa-hourglass-half"></i> &nbsp; PEDIDOS PENDIENTES</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVER_URL; ?>placed-order-list/"><i class="fas fa-clipboard-check"></i> &nbsp; PEDIDOS REALIZADOS</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVER_URL; ?>order-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO</a>
                    </li>
                </ul>
</div>

<div class="container-fluid">
<?php
    require_once "./controladores/pedidoControlador.php";
    $ins_pedido = new pedidoControlador();

    $datos_pedido = $ins_pedido->datos_pedido_controlador("Unico", $pagina[1]);

    if ($datos_pedido->rowCount() >= 1) {
        $campos_1 = $datos_pedido->fetch();
        if($campos_1['estado_pedido']=="Realizado"){
    ?>
        <div class="alert alert-danger text-center" role="alert">
            <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
            <h4 class="alert-heading">¡Pedido realizado!</h4>
            <p class="mb-0">No puedes actualizar el pedido debido a que ya se encuentrar realizado.</p>
        </div>
<?php
    } else {
    ?>
    <div class="container-fluid form-neon">
        <div class="container-fluid">
        <!-- <p class="text-center roboto-medium">AGREGAR CLIENTE Y PRODUCTOS</p>
            <p class="text-center">


                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalProducto"><i class="fas fa-box-open"></i> &nbsp; Agregar producto</button>
            </p>-->
            <?php
            require_once "./controladores/clienteControlador.php";
            $ins_cliente = new clienteControlador();
        
            $datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $lc->encryption($campos_1['id_client']));
            $campos=$datos_cliente->fetch();
            
            ?>
            <div>
                <span class="roboto-medium">CLIENTE:</span>
                        <?php echo $campos['cliente_rif'] . " - " . $campos['cliente_razon']; ?>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>PRODUCTO</th>
                            <th>CANTIDAD</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*if (isset($_SESSION['datos_producto']) && count($_SESSION['datos_producto']) >= 1) {
                            $_SESSION['total_producto'] = 0;*/
                            $datos_pedido = $ins_pedido->datos_pedido_controlador("Unico", $pagina[1]);
                            $detalle=$datos_pedido->fetchAll();
                            foreach ($detalle as $productos) {
                        ?>
                                <tr class="text-center">
                                    <td><?php echo $productos['producto_nombre'] ?></td>
                                    <td><?php echo $productos['cantidad_detalle'] ?></td>
                                    
                                    <td>
                                        <form class=" FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/pedidoAjax.php" method="POST" data-form="order" autocomplete="off">
                                        <input type="hidden" name="id_eliminar_producto" value="<?php echo $producto['ID']?>">
                                            <button type="submit" class="btn btn-warning">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                                /*$_SESSION['total_producto'] += $producto['Cantidad'];*/
                            }
                            ?>
                            <tr class="text-center bg-light">
                                <td><strong>TOTAL</strong></td>
                                <td><strong><?php echo $campos_1['cantidad_pedido']; ?> Productos</strong></td>
                                <td></td>
                                

                            </tr>
                        <?php
                        /*} else {
                            $_SESSION['total_producto'] = 0;*/
                        ?>
                            
                        <?php
                        /*}*/
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/pedidoAjax.php" method="POST" data-form="uptade" autocomplete="off">
        <input type="hidden" name="codigo_pedido_up" value="<?php echo $pagina[1]?>">
        <fieldset>
						<div class="form-group">
							<select class="form-control" name="estado_pedido_up">
								<option value="" selected="">Seleccione el estado del pedido</option>
								<option value="Pendiente">Pendiente</option>
								<option value="Realizado">Realizado</option>

							</select>
						</div>
	
		</fieldset>
        
        <p class="text-center" style="margin-top: 20px;">
            <button type="submit" class="btn btn-raised btn-success btn-sm"><i class="far fa-save"></i> &nbsp; ACTUALIZAR</button>
        </p>

            
        </form>
    </div>
</div>



<!-- MODAL CLIENTE -->
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="ModalCliente" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCliente">Agregar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_cliente" class="bmd-label-floating">RIF, Nombre, Apellido, Telefono</label>

                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_cliente" id="input_cliente" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_clientes">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_cliente()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PRODUCTO -->
<div class="modal fade" id="ModalProducto" tabindex="-1" role="dialog" aria-labelledby="ModalProducto" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalProducto">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{2,30}" class="form-control" name="input_producto" id="input_producto" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_productos">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="buscar_producto()"><i class="fas fa-search fa-fw"></i> &nbsp; Buscar</button>
                &nbsp; &nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL AGREGAR PRODUCTO -->
<div class="modal fade" id="ModalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarProducto" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/pedidoAjax.php" method="POST" data-form="default" autocomplete="off">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarProducto">Selecciona la cantidad de productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_agregar_producto" id="id_agregar_producto">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="detalle_cantidad" class="bmd-label-floating">Cantidad de producto</label>
                                <input type="num" pattern="[0-9]{1,7}" class="form-control" name="detalle_cantidad" id="detalle_cantidad" maxlength="7" required="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                &nbsp; &nbsp;
                <button type="button" onclick="modal_buscar_producto()" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<?php
    }
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
<?php 
include_once "./vistas/inc/reservation.php";
?>
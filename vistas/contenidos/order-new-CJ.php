<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO PEDIDO
    </h3><!--  ESCUCHAR EL AUDIO EN TU CHAT PARA SABER LA IDEA DE COMO HACER ESTA MONDAAAA  -->
    <p class="text-justify">

    </p>
</div>


<div class="container-fluid">
    <div class="container-fluid form-neon">
        <div class="container-fluid">
            <p class="text-center roboto-medium">AGREGAR CLIENTE Y PRODUCTOS</p>
            <p class="text-center">
                <?php if(empty($_SESSION['datos_cliente'])){ ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCliente"><i class="fas fa-user-plus"></i> &nbsp; Agregar cliente</button>
                <?php } ?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalItem"><i class="fas fa-box-open"></i> &nbsp; Agregar producto</button>
            </p>
            <div>
                <span class="roboto-medium">CLIENTE:</span>

                <?php if(empty($_SESSION['datos_cliente'])){ ?>

                <span class="text-danger">&nbsp; <i class="fas fa-exclamation-triangle"></i> Seleccione un cliente</span>
                
                <?php }else{ ?>

                <form class=" FormularioAjax" action="<?php echo SERVER_URL ?>ajax/pedidoAjax.php" method="POST" data-form="order" style="display: inline-block !important;">
                <input type="hidden" name="id_eliminar_cliente" value="<?php echo $_SESSION['datos_cliente']['ID'] ?>">
                    <?php echo $_SESSION['datos_cliente']['RIF']." - ". $_SESSION['datos_cliente']['Razon'];?>
                    <button type="submit" class="btn btn-danger"><i class="fas fa-user-times"></i></button>
                </form>
                
                <?php } ?>

            </div>
            <div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>ITEM</th>
                            <th>CANTIDAD</th>
                            <th>TIEMPO</th>
                            <th>COSTO</th>
                            <th>SUBTOTAL</th>
                            <th>DETALLE</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center">
                            <td>Silla plastica</td>
                            <td>7</td>
                            <td>Hora</td>
                            <td>$5.00</td>
                            <td>$35.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <form action="">
                                    <button type="button" class="btn btn-warning">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Silla metalica</td>
                            <td>9</td>
                            <td>Día</td>
                            <td>$5.00</td>
                            <td>$45.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <form action="">
                                    <button type="button" class="btn btn-warning">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>Mesa plastica</td>
                            <td>5</td>
                            <td>Evento</td>
                            <td>$10.00</td>
                            <td>$50.00</td>
                            <td>
                                <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="Nombre del item" data-content="Detalle completo del item">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </td>
                            <td>
                                <form action="">
                                    <button type="button" class="btn btn-warning">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr class="text-center bg-light">
                            <td><strong>TOTAL</strong></td>
                            <td><strong>21 items</strong></td>
                            <td colspan="2"></td>
                            <td><strong>$130.00</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <form action="" autocomplete="off">
            <fieldset>
                <legend class="text-center"><i class="fas fa-clipboard-list"></i> &nbsp; Informacion del Pedido</legend>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="fecha_pedido">Fecha del Pedido</label>
                                <input type="date" class="form-control" name="fecha_pedido_reg" id="fecha_pedido">
                            </div>
                        </div>
                        <input type="hidden" name="pedido_estado_reg" value="Pendiente">
                    </div>
                </div>
            </fieldset>
            <br><br><br>
            <p class="text-center" style="margin-top: 40px;">
                <button type="reset" class="btn btn-raised btn-secondary btn-sm"><i class="fas fa-paint-roller"></i> &nbsp; LIMPIAR</button>
                &nbsp; &nbsp;
                <button type="submit" class="btn btn-raised btn-info btn-sm"><i class="far fa-save"></i> &nbsp; GUARDAR</button>
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
<div class="modal fade" id="ModalItem" tabindex="-1" role="dialog" aria-labelledby="ModalItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalItem">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="input_item" class="bmd-label-floating">Código, Nombre</label>
                        <input type="text" pattern="[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" name="input_producto" id="input_producto" maxlength="30">
                    </div>
                </div>
                <br>
                <div class="container-fluid" id="tabla_productos"  >
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


<!-- MODAL AGREGAR ITEM -->
<div class="modal fade" id="ModalAgregarItem" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarItem" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content FormularioAjax">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarItem">Selecciona la cantidad de productos</h5>
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
                <button type="button" class="btn btn-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>
    <?php 
    include_once "./vistas/inc/reservation.php";
    ?>
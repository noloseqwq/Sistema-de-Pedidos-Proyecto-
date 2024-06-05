            <?php
            ?>
            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-center">
                    <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PRODUCTOS
                </h3>
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
                        <a class="active" href="<?php echo SERVER_URL; ?>placed-order-list/"><i class="fas fa-clipboard-check"></i> &nbsp; PEDIDOS REALIZADOS</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVER_URL; ?>order-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PEDIDO</a>
                    </li>
                </ul>
            </div>

            <!--CONTENT-->
            <div class="container-fluid">
            <?php
					require_once "./controladores/pedidoControlador.php";
					$ins_pedidoTab = new pedidoControlador();
					
					echo $ins_pedidoTab->paginador_pedido_controlador($pagina[1],8, $_SESSION['privilegio_sdp'],$pagina[0],"Realizado","");


				?>
            </div>
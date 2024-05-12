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
                        <a href="<?php echo SERVER_URL; ?>product-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PRODUCTO</a>
                    </li>
                    <li>
                        <a class="active" href="<?php echo SERVER_URL; ?>product-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PRODUCTOS</a>
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
					$ins_productoTab = new productoControlador();
					
					echo $ins_productoTab->paginador_producto_controlador($pagina[1],50, $_SESSION['privilegio_sdp'],$pagina[0],"");


				?>
            </div>
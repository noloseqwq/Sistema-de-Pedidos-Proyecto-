            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-center">
                    <i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PRODUCTO
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
                        <a class="active" href="<?php echo SERVER_URL; ?>product-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR PRODUCTO</a>
                    </li>
                </ul>
            </div>

            <?php 
            if(!isset($_SESSION['busquedad_producto']) && empty($_SESSION['busquedad_producto'])){
            ?>
            <div class="container-fluid">
            <form class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off">
					<input type="hidden" name="modulo" value="producto">
            
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="inputSearch" class="bmd-label-floating">¿Qué Producto estas buscando?</label>
                                    <input type="text" class="form-control" name="busqueda_inicial" id="inputSearch" >
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
                        <input type="hidden" name="modulo" value="producto"> 
						<input type="hidden" name="eliminar_busqueda" value="eliminar">
                    <div class="container-fluid">
                        <div class="row justify-content-md-center">
                            <div class="col-12 col-md-6">
                            <p class="text-center" style="font-size: 20px;">
										Resultados de la busqueda <strong>“<?php echo $_SESSION['busquedad_producto'];?>”</strong>
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
                require_once "./controladores/productoControlador.php";
                $ins_productoTab = new productoControlador();
                
                echo $ins_productoTab->paginador_producto_controlador($pagina[1],8, $_SESSION['privilegio_sdp'],$pagina[0],$_SESSION['busquedad_producto']);


            ?>
                
            </div>
            <?php } ?>
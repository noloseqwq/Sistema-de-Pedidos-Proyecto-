            <!-- Page header -->
            <div class="full-box page-header">
                <h3 class="text-left">
                    <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PRODUCTO
                </h3>
            </div>

            <div class="container-fluid">
                <ul class="full-box list-unstyled page-nav-tabs">
                    <li>
                        <a class="active" href="<?php echo SERVER_URL; ?>product-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR PRODUCTO</a>
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
                <form action="" class="form-neon" autocomplete="off">
                    <fieldset>
                        <legend class=" text-center"><i class="fas fa-boxes"></i> &nbsp; Informacion del producto</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="producto_codigo" class="bmd-label-floating">Códido</label>
                                        <input type="text" pattern="[A-Z0-9]{3,6}" class="form-control" name="producto_codigo_reg" id="producto_codigo" maxlength="6" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-9">
                                    <div class="form-group">
                                        <label for="producto_nombre" class="bmd-label-floating">Nombre del producto</label>
                                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{14,100}" class="form-control" name="producto_nombre_reg" id="producto_nombre" maxlength="140">
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-12">
                                    <div class="form-group">
                                        <label for="producto_detalle" class="bmd-label-floating">Descripción </label>
                                        <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{1,190}" class="form-control" name="producto_detalle_reg" id="producto_detalle" maxlength="190">
                                    </div>
                                </div>
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
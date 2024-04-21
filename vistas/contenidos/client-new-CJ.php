<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE
    </h3>
</div>

<div class="container-fluid">
    <ul class="full-box list-unstyled page-nav-tabs">
        <li>
            <a class="active" href="<?php echo SERVER_URL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>client-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE CLIENTES</a>
        </li>
        <li>
            <a href="<?php echo SERVER_URL; ?>client-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR CLIENTE</a>
        </li>
    </ul>
</div>

<!-- Content here-->
<div class="container-fluid">
    <form class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/clienteAjax.php" method="POST" data-form="save" autocomplete="off">
        <fieldset>
            <legend class=" text-center"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_RIF" class="bmd-label-floating">RIF</label>
                            <input type="text" pattern="[0-9\-]{6,20}" class="form-control" name="cliente_RIF_reg" id="cliente_RIF" maxlength="20">
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
                            <input type="text" pattern="[0-9\-]{11,12}" class="form-control" name="cliente_telefono_reg" id="cliente_telefono" maxlength="12">
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="form-group">
                            <label for="cliente_razon" class="bmd-label-floating">Razon Social</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}" class="form-control" name="cliente_razon_reg" id="cliente_razon" maxlength="50">
                        </div>
                    </div>
                    <div class="col-12 col-md-7">
                        <div class="form-group">
                            <label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
                            <input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}" class="form-control" name="cliente_direccion_reg" id="cliente_direccion" maxlength="50">
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
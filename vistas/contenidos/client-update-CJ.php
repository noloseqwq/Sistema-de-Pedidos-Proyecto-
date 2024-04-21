<?php
if ($_SESSION['privilegio_sdp'] < 1 || $_SESSION['privilegio_sdp'] > 2) {
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}
?>
<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR CLIENTE
	</h3>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVER_URL; ?>client-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; AGREGAR CLIENTE</a>
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
	<?php
	require_once "./controladores/clienteControlador.php";
	$ins_cliente = new clienteControlador();

	$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $pagina[1]);

	if ($datos_cliente->rowCount() == 1) {
		$campos=$datos_cliente->fetch();

	?>
		<form  class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
		<input type="hidden" name="id_cliente_up" value="<?php echo $pagina[1] ?>">
			<fieldset>
				<legend class=" text-center"><i class="fas fa-user"></i> &nbsp; Información básica</legend>
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-12 col-md-5">
							<div class="form-group">
								<label for="cliente_telefono" class="bmd-label-floating">Teléfono</label>
								<input type="text" pattern="[0-9\-]{11,12}" class="form-control" name="cliente_telefono_up" id="cliente_telefono" maxlength="12" value="<?php echo $campos['cliente_tlf']?>">
							</div>
						</div>

						<div class="col-12 col-md-7">
							<div class="form-group">
								<label for="cliente_direccion" class="bmd-label-floating">Dirección</label>
								<input type="text" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}" class="form-control" name="cliente_direccion_up" id="cliente_direccion" maxlength="50" value="<?php echo $campos['cliente_direccion']?>">
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
	}else{
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
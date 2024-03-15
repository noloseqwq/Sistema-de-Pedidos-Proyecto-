<?php

if($lc->encryption($_SESSION['id_sdp'])!=$pagina[1]){
	if ($_SESSION['privilegio_sdp'] != 1) {
		echo $lc->forzar_cierre_sesion_controlador();
		exit();
	}
}



?>
<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
	</h3>
	<p class="text-justify">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
	</p>
</div>
<?php if($_SESSION['privilegio_sdp']==1){ ?>
<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVER_URL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVER_URL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVER_URL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>
</div>
<?php }?>
<!-- Content -->
<div class="container-fluid">
	<?php 
		require_once "./controladores/usuarioControlador.php";
		$ins_usuario = new usuarioControlador();

		$datos_usuario=$ins_usuario->datos_usuario_controlador("Unico",$pagina[1]);

	if($datos_usuario->rowCount()==1){
		$campos= $datos_usuario->fetch();
	?>
	<form class="form-neon FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
	<input type="hidden" name="id_usuario_up" value="<?php echo $pagina[1] ?>">
		<fieldset>
			<legend><i class="far fa-address-card"></i> &nbsp; Información personal</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_CI" class="bmd-label-floating">Cedúla de Identidad</label>
							<input type="text" pattern="[0-9\-]{6,20}" class="form-control" name="usuario_CI_up" id="usuario_CI" maxlength="20" value="<?php echo $campos['CI']?>" required>
						</div>
					</div>

					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_nombre" class="bmd-label-floating">Nombres</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,35}" class="form-control" name="usuario_nombre_up" id="usuario_nombre" maxlength="35" value="<?php echo $campos['nombre']?>" required>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="form-group">
							<label for="usuario_apellido" class="bmd-label-floating">Apellidos</label>
							<input type="text" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,35}" class="form-control" name="usuario_apellido_up" id="usuario_apellido" maxlength="35" value="<?php echo $campos['apellido']?>" required>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_usuario" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{3,35}" class="form-control" name="usuario_usuario_up" id="usuario_usuario" maxlength="35" value="<?php echo $campos['usuario']?>" required>
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_email" class="bmd-label-floating">Email</label>
							<input type="email" class="form-control" name="usuario_email_up" id="usuario_email" maxlength="70" value="<?php echo $campos['email']?>" required>
						</div>
					</div>
					
				</div>
			</div>
		</fieldset>
		
		<br><br><br>
		<fieldset>
			<legend style="margin-top: 40px;"><i class="fas fa-lock"></i> &nbsp; Nueva contraseña</legend>
			<p>Para actualizar la contraseña de esta cuenta ingrese una nueva y vuelva a escribirla. En caso que no desee actualizarla debe dejar vacíos los dos campos de las contraseñas.</p>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_nueva_1" class="bmd-label-floating">Contraseña</label>
							<input type="password" class="form-control" name="usuario_clave_1_up" id="usuario_clave_nueva_1" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_clave_nueva_2" class="bmd-label-floating">Repetir contraseña</label>
							<input type="password" class="form-control" name="usuario_clave_2_up" id="usuario_clave_up_2" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100">
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<?php if($_SESSION['privilegio_sdp']==1 && $campos['id_usuario']!=1){?>
		<br><br><br>
		<fieldset>
			<legend><i class="fas fa-medal"></i> &nbsp; Nivel de privilegio</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<p><span class="badge badge-info">Control total</span> Permisos para registrar, actualizar y eliminar</p>
						<p><span class="badge badge-success">Edición</span> Permisos para registrar y actualizar</p>
						<p><span class="badge badge-dark">Registrar</span> Solo permisos para registrar</p>
						<div class="form-group">
							<select class="form-control" name="usuario_privilegio_up">
								<option value="1" <?php if($campos['privilegio']==1){echo'selected=""';} ?> >Control total <?php if($campos['privilegio']==1){echo'(Actual)';} ?></option>

								<option value="2" <?php if($campos['privilegio']==2){echo'selected=""';} ?>>Edición <?php if($campos['privilegio']==2){echo'(Actual)';} ?></option>

								<option value="3" <?php if($campos['privilegio']==3){echo'selected=""';} ?>>Registrar <?php if($campos['privilegio']==3){echo'(Actual)';} ?></option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<?php } ?>
		<br><br><br>
		<fieldset>
			<p class="text-center">Para poder guardar los cambios en esta cuenta debe de ingresar su nombre de usuario y contraseña</p>
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="usuario_admin" class="bmd-label-floating">Nombre de usuario</label>
							<input type="text" pattern="[a-zA-Z0-9]{3,35}" class="form-control" name="usuario_admin" id="usuario_admin" maxlength="35" required="">
						</div>
					</div>
					<div class="col-12 col-md-6">
						<div class="form-group">
							<label for="clave_admin" class="bmd-label-floating">Contraseña</label>
							<input type="password" class="form-control" name="clave_admin" id="clave_admin" pattern="[a-zA-Z0-9$@.\-]{7,100}" maxlength="100" required="">
						</div>
					</div>
				</div>
			</div>
		</fieldset>
		<?php if($lc->encryption($_SESSION['id_sdp'])!=$pagina[1]){?>
			<input type="hidden" name="tipo_cuenta" value="Impropia">
		<?php }else{?>
			<input type="hidden" name="tipo_cuenta" value="Propia">
		<?php }?>
		<p class="text-center" style="margin-top: 40px;">
			<button type="submit" class="btn btn-raised btn-success btn-sm"><i class="fas fa-sync-alt"></i> &nbsp; ACTUALIZAR</button>
		</p>
	</form>
<?php }else{?>
	<div class="alert alert-danger text-center" role="alert">
		<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
		<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
		<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
	</div>
	<?php }?>
</div>
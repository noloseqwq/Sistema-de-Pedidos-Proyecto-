<?php
if ($_SESSION['privilegio_sdp'] != 1) {
	echo $lc->forzar_cierre_sesion_controlador();
	exit();
}
?>
<!-- Page header -->
<div class="full-box page-header">
	<h3 class="text-left text-center">
		<i class="fas fa-database"></i> &nbsp; BASE DE DATOS
	</h3>

</div>
<div class="container-fluid ">
	<div class="form-neon">
		<form class=" FormularioAjax " data-form="restore" action="<?php echo SERVER_URL ?>ajax/bdAjax.php" method="POST">
			<legend class="text-center"></i> &nbsp; Restauracion y Respaldo de base de datos</legend>
			<select class="form-control" name="restore" required>
				<option value="" disabled="" selected="">Selecciona un punto de restauración</option>
				<?php
		
				$ruta = 'backup/';
				if (is_dir($ruta)) {
					if ($aux = opendir($ruta)) {
						while (($archivo = readdir($aux)) !== false) {
							if ($archivo != "." && $archivo != "..") {
								$nombrearchivo = str_replace(".sql", "", $archivo);
								$nombrearchivo = str_replace("-", ":", $nombrearchivo);
								$ruta_completa = $ruta . $archivo;
								if (is_dir($ruta_completa)) {
								} else {
									echo '<option value="' . $ruta_completa . '">' . $nombrearchivo . '</option>';
								}
							}
						}
						closedir($aux);
					}
				} else {
					echo $ruta . " No es ruta válida";
				}
				?>
			</select>
		
		
				<div class="d-flex 	justify-content-center mt-4">
					<button class="btn btn-raised btn-secondary btn-sm" type="submit">Restaurar</button>
				</div>
			</form>
			<div class="d-flex 	justify-content-center">
				<form class=" FormularioAjax" data-form="backup" action="<?php echo SERVER_URL ?>ajax/bdAjax.php" method="POST">
					<input type="hidden" name="backup" value="">
					<button class="btn btn-raised btn-success btn-sm" type="submit">Realizar copia de seguridad</button>
				</form>
			</div>
		
	</div>

</div>
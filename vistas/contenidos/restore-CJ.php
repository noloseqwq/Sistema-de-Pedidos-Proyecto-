<form class=" " data-form="default" action="<?php echo SERVER_URL?>ajax/bdAjax.php" method="POST">
    <button type="submit" name="backup">Realizar copia de seguridad</button>
</form>
	<form data-form="default" action="<?php echo SERVER_URL?>ajax/bdAjax.php" method="POST">
		<label>Selecciona un punto de restauración</label><br>
		<select name="restore" required>
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
		<button type="submit">Restaurar</button>
	</form>
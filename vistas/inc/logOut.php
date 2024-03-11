<script>
    let btn_salir=document.querySelector(".btn-exit-system");

    btn_salir.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
			title: 'Quieres salir del sistema?',
			text: "La sesion actual se cerrara y saldras del sistema",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.value) {
				
                let url='<?php echo SERVER_URL;?>ajax/loginAjax.php';
                let token= '<?php echo $lc -> encryption($_SESSION['token_sdp'])?>';
                let usuario= '<?php echo $lc -> encryption($_SESSION['usuario_sdp'])?>'; 

                let datos = new FormData();
				datos.append("token", token);
				datos.append("usuario", usuario);

				fetch(url, {
					method: 'post',
					body: datos
				})
				.then(respuesta => respuesta.json())
				.then(respuesta => {
					return alertas_ajax(respuesta)
				});
			}
		});
        
    });
</script>
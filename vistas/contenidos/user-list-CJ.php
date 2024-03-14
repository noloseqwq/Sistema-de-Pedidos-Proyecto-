			<?php
			if($_SESSION['privilegio_sdp']!=1){
				echo $lc -> forzar_cierre_sesion_controlador();
				exit();
			}
			?>
			<!-- Page header -->
			<div class="full-box page-header">
				<h3 class="text-left">
					<i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS
				</h3>
				<p class="text-justify">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
				</p>
			</div>

			<div class="container-fluid">
				<ul class="full-box list-unstyled page-nav-tabs">
					<li>
						<a href="<?php echo SERVER_URL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
					</li>
					<li>
						<a class="active" href="<?php echo SERVER_URL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
					</li>
					<li>
						<a href="<?php echo SERVER_URL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
					</li>
				</ul>
			</div>

			<!-- Content -->
			<div class="container-fluid">
				<?php
					require_once "./controladores/usuarioControlador.php";
					$ins_usuarioTab = new usuarioControlador();
					
					echo $ins_usuarioTab->paginador_usuario_controlador($pagina[1],8, $_SESSION['privilegio_sdp'],$_SESSION['id_sdp'],$pagina[0],"");


				?>
			</div>
    <!-- Page header -->
    <div class="full-box page-header">
        <h3 class="text-left">
            <i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE PEDIDOS
        </h3>
    </div>
	<?php
	require_once "./controladores/clienteControlador.php";
	$ins_cliente = new clienteControlador();

	$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $pagina[1]);

	if ($datos_cliente->rowCount() == 1) {
		$campos=$datos_cliente->fetch();

	?>
    <div class="contenedor">
        <div class="cliente ">
        <i class="fas fa-users fa-7x"></i>
        <div class=" h5 text-center mt-1">Cliente:  <b><?php echo $campos['cliente_rif'].' - '.$campos['cliente_razon']?></b> </div>
        </div>
        <div class="pedidos-cliente ">
        <?php
					require_once "./controladores/pedidoControlador.php";
					$ins_pedidoTab = new pedidoControlador();
					
					echo $ins_pedidoTab->paginador_pedido_individual_controlador($pagina[2],6, $_SESSION['privilegio_sdp'],$pagina[0],$pagina[1]);


				?>

    </div>
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
    

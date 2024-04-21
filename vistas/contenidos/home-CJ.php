<!-- Page header -->
<div class="full-box page-header">
    <h3 class="text-left">
        <i class="fas fa-home fa-fw"></i> &nbsp; Inicio
    </h3>

</div>

<!-- Content -->
<div class="full-box tile-container">
    <?php
    require_once "./controladores/clienteControlador.php";
    $ins_cliente= new clienteControlador();
    $total_clientes=$ins_cliente->datos_cliente_controlador("Conteo",0)
    ?>
    <a href="<?php echo SERVER_URL; ?>client-list/" class="tile">
        <div class="tile-tittle">Clientes</div>
        <div class="tile-icon">
            <i class="fas fa-users fa-fw"></i>
            <p><?php echo $total_clientes->rowCount()?> Registrados</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>order-list/" class="tile">
        <div class="tile-tittle">Pedidos</div>
        <div class="tile-icon">
            <i class="fas fa-clipboard-list fa-fw"></i>
            <p>9 Registrados</p>
        </div>
    </a>

    <a href="<?php echo SERVER_URL; ?>product-list/" class="tile">
        <div class="tile-tittle">Productos</div>
        <div class="tile-icon">
            <i class="fas fa-boxes fa-fw"></i>
            <p>30 Registradas</p>
        </div>
    </a>
    <?php if($_SESSION['privilegio_sdp']==1){
        require_once "./controladores/usuarioControlador.php";
        $ins_usuario= new usuarioControlador();
        $total_usuarios= $ins_usuario->datos_usuario_controlador("Conteo",0);
    ?>
    <a href="<?php echo SERVER_URL; ?>user-list/" class="tile">
        <div class="tile-tittle">Usuarios</div>
        <div class="tile-icon">
            <i class="fas fa-user fa-fw"></i>
            <p><?php echo $total_usuarios->rowCount(); ?> Registrados</p>
        </div>
    </a>
    <?php }?>
    
</div>


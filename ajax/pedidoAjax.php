<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['buscar_cliente']) || isset($_POST['id_agregar_cliente']) || isset($_POST['id_producto_up'])){

        /*-------- Intancia al controlador --------*/
        require_once "../controladores/pedidoControlador.php";
        $ins_pedido = new pedidoControlador();

        /*-------- buscar cliente --------*/
        if(isset($_POST['buscar_cliente'])){
            echo $ins_pedido->buscar_cliente_pedido_controlador();
        }
        
        /*-------- Agregar cliente --------*/
        if(isset($_POST['id_agregar_cliente'])){
            echo $ins_pedido->agregar_cliente_pedido_controlador();
        }  
        
        /*-------- Eliminar producto
        if(isset($_POST['id_producto_del'])){
                echo $ins_producto->eliminar_producto_controlador();
        }--------*/
        
        /*-------- Actualizar producto
        if(isset($_POST['id_producto_up'])){
            echo $ins_producto->actualizar_producto_controlador();
        } --------*/
    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
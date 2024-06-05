<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['buscar_cliente']) || isset($_POST['id_agregar_cliente']) || isset($_POST['id_eliminar_cliente']) || isset($_POST['buscar_producto']) || isset($_POST['id_agregar_producto']) || isset($_POST['id_eliminar_producto']) || isset($_POST['fecha_emision_pedido_reg']) || isset($_POST['codigo_pedido_del'])  || isset($_POST['codigo_pedido_up'])  ){

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
        
        /*-------- Eliminar cliente--------*/
        if(isset($_POST['id_eliminar_cliente'])){
                echo $ins_pedido->eliminar_cliente_pedido_controlador();
        }
        
        /*-------- buscar producto--------*/
        if(isset($_POST['buscar_producto'])){
            echo $ins_pedido->buscar_producto_pedido_controlador();
        }
        
        /*-------- agregar producto--------*/
        if(isset($_POST['id_agregar_producto'])){
            echo $ins_pedido->agregar_producto_pedido_controlador();
        } 

        /*-------- eliminar producto--------*/
        if(isset($_POST['id_eliminar_producto'])){
            echo $ins_pedido->eliminar_producto_pedido_controlador();
        }

        /*-------- agregar pedido--------*/
        if(isset($_POST['fecha_emision_pedido_reg'])){
            echo $ins_pedido->agregar_pedido_controlador();
        }
        
        /*-------- eliminar pedido--------*/
        if(isset($_POST['codigo_pedido_del'])){
            echo $ins_pedido->eliminar_pedido_controlador();
        }
    
        /*-------- Actualizar pedido--------*/
        if( isset($_POST['codigo_pedido_up']) ){
            echo $ins_pedido->actualizar_pedido_controlador();
        }


    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
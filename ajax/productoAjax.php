<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['producto_codigo_reg']) || isset($_POST['id_producto_del']) || isset($_POST['id_producto_up'])){

        /*-------- Intancia al controlador --------*/
        require_once "../controladores/productoControlador.php";
        $ins_producto = new productoControlador();

        /*-------- Agregar producto--------*/
        if(isset($_POST['producto_codigo_reg'])){
            echo $ins_producto->agregar_producto_controlador();
        }  
        
        /*-------- Eliminar producto--------*/
        if(isset($_POST['id_producto_del'])){
                echo $ins_producto->eliminar_producto_controlador();
        }
        
        /*-------- Actualizar producto--------*/
        if(isset($_POST['id_producto_up'])){
            echo $ins_producto->actualizar_producto_controlador();
        } 
    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
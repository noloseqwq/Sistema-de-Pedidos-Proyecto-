<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['cliente_CI_reg'])){

        /*-------- Intancia al controlador --------*/
        require_once "../controladores/clienteControlador.php";
        $ins_cliente = new clienteControlador();

        /*-------- Agregar cliente --------*/
        if(isset($_POST['cliente_CI_reg']) && isset($_POST['cliente_razon_reg']) ){
            echo $ins_cliente->agregar_cliente_controlador();
            
        }  
        
        /*-------- Eliminar cliente
            if(isset($_POST['id_cliente_del'])){
                echo $ins_cliente->eliminar_cliente_controlador();
            } --------*/
        /*-------- Actualizar cliente 
        if(isset($_POST['id_cliente_up'])){
            echo $ins_cliente->actualizar_cliente_controlador();
        }--------*/
    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
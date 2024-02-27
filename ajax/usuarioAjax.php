<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['usuario_CI_reg'])){

        /*-------- Intancia al controlador --------*/
        require_once "../controladores/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();

        /*-------- Agregar usuario --------*/
        if(isset($_POST['usuario_CI_reg']) && isset($_POST['usuario_usuario_reg'])){
            echo $ins_usuario->agregar_usuario_controlador();
        }
    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
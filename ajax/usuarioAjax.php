<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if($a){

        /*-------- Intancia al controlador --------*/
        require_once "../controladores/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();
    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }
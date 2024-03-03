<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(){


    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }

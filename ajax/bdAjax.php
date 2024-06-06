<?php
    $peticionAjax = true;
    require_once "../config/APP.php";

    if(isset($_POST['backup']) || isset($_POST['restore'])){
        
        /*-------- Intancia al controlador --------*/
        require_once "../controladores/bdControlador.php";
        $ins_bd = new bdControlador();

        /*-------- respaldo de la BD --------*/
        if(isset($_POST['backup'])){
            echo $ins_bd->backup_bd_controlador();
        }
        
        /*-------- restauracion de la BD --------*/
        if(isset($_POST['restore'])){
            echo $ins_bd->restore_bd_controlador();
        }

        




    }else{
        session_start(['name' => 'SDP']);
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
    }

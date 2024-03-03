<?php

require_once "mainModel.php";

class loginModelo extends mainModel{

    /*--------Modelo para inciar sesion--------*/
    protected static function iniciar_sesion_modelo($datos){
        $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE usuario=:Usuario AND clave=:Clave");
        $sql->bindParam(":Usuario", $datos['Usuario']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->execute();
        
        return $sql;
    }
}
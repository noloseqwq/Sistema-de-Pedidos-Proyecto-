<?php

require_once "mainModel.php";

class loginModelo extends mainModel{

    /*--------Modelo para iniciar sesión--------*/
    protected static function iniciar_sesion_modelo($datos){
        $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios, persona WHERE usuario=:Usuario AND clave=:Clave AND id_usuario=id_usu");
        $sql->bindParam(":Usuario", $datos['Usuario']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->execute();
        
        return $sql;
    }
}
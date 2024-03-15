<?php

require_once "mainModel.php";

class usuarioModelo extends mainModel{

    /*-------- Modelo agregar usuario --------*/
    protected static function agregar_usuario_modelo($datos){
        $sql = mainModel::conectar()->prepare("INSERT INTO usuarios(usuario, nombre, apellido, CI, email, clave, privilegio) VALUES(:Usuario, :Nombre, :Apellido, :CI, :EMAIL, :Clave, :Privilegio)");

        $sql->bindParam(":Usuario", $datos['Usuario']);
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":CI", $datos['CI']);
        $sql->bindParam(":EMAIL", $datos['EMAIL']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->bindParam(":Privilegio", $datos['Privilegio']);
        $sql->execute();

        return $sql;
    }
    /*-------- Modelo eliminar usuario --------*/

    protected static function eliminar_usuario_modelo($id){
        $sql= mainModel::conectar()->prepare("DELETE FROM usuarios WHERE id_usuario=:ID");

        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*-------- Modelo datos usuario --------*/
    protected static function datos_usuario_modelo($tipo,$id){
        if($tipo=="Unico"){
            $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios WHERE id_usuario=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Conteo"){
            $sql=mainModel::conectar()->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario!=1");
        }
        $sql->execute();

        return $sql;
    }
    /*-------- Modelo actualizar datos usuario --------*/
    protected static function actualizar_usuario_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE usuarios SET usuario=:Usuario, nombre=:Nombre, apellido=:Apellido, CI=:CI, email=:EMAIL, clave=:Clave, privilegio=:Privilegio WHERE id_usuario=:ID ");

        $sql->bindParam(":Usuario", $datos['Usuario']);
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":CI", $datos['CI']);
        $sql->bindParam(":EMAIL", $datos['EMAIL']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->bindParam(":Privilegio", $datos['Privilegio']);
        $sql->bindParam(":ID", $datos['ID']);
        $sql->execute();

        return $sql;
    }
    
}

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
}

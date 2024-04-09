<?php

require_once "mainModel.php";

class clienteModelo extends mainModel{

    /*-------- Modelo agregar cliente --------*/
    protected static function agregar_cliente_modelo($datos){
        $sql = mainModel::conectar()->prepare("INSERT INTO cliente(cliente_CI, cliente_nombre,cliente_apellido, cliente_tlf,cliente_razon,cliente_direccion)VALUES(:CI, :Nombre, :Apellido,:TLF,:Razon,:Direccion)");
        
        $sql->bindParam(":CI", $datos['CI']);
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":TLF", $datos['TLF']);
        $sql->bindParam(":Razon", $datos['Razon']);
        $sql->bindParam(":Direccion", $datos['Direccion']);
        $sql->execute();

        return $sql;



    }


}
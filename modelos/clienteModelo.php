<?php

require_once "mainModel.php";

class clienteModelo extends mainModel{

    /*-------- Modelo agregar cliente --------*/
    protected static function agregar_cliente_modelo($datos){
        $sql = mainModel::conectar()->prepare("INSERT INTO cliente(cliente_rif, cliente_nombre,cliente_apellido, cliente_tlf,cliente_razon,cliente_direccion)VALUES(:RIF, :Nombre, :Apellido,:TLF,:Razon,:Direccion)");
        
        $sql->bindParam(":RIF", $datos['RIF']);
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":TLF", $datos['TLF']);
        $sql->bindParam(":Razon", $datos['Razon']);
        $sql->bindParam(":Direccion", $datos['Direccion']);
        $sql->execute();

        return $sql;

    }

    /*-------- Modelo eliminar cliente --------*/
    protected static function eliminar_cliente_modelo($id){
        $sql = mainModel::conectar()->prepare("DELETE FROM cliente WHERE id_cliente=:ID");
        
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }
}
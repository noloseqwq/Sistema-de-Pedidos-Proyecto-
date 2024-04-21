<?php

require_once "mainModel.php";

class clienteModelo extends mainModel{

    /*-------- Modelo agregar cliente --------*/
    protected static function agregar_cliente_modelo($datos){
        $sql = mainModel::conectar()->prepare("INSERT INTO cliente(cliente_rif, cliente_tlf,cliente_razon,cliente_direccion)VALUES(:RIF, :TLF,:Razon,:Direccion)");
        
        $sql->bindParam(":RIF", $datos['RIF']);
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

    /*-------- Modelo datos cliente --------*/
    protected static function datos_cliente_modelo($tipo,$id){
        if($tipo=="Unico"){
            $sql=mainModel::conectar()->prepare("SELECT * FROM cliente WHERE id_cliente=:ID");
            $sql->bindParam(":ID",$id);
        }elseif($tipo=="Conteo"){
            $sql=mainModel::conectar()->prepare("SELECT id_cliente FROM cliente");
        }
        $sql->execute();
        return $sql;
    }

    /*-------- Modelo actualizar cliente --------*/
    protected static function actualizar_cliente_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE cliente SET cliente_tlf =:TLF, cliente_direccion=:Direccion WHERE id_cliente=:ID ");
        $sql->bindParam(":TLF", $datos['TLF']);
        $sql->bindParam(":Direccion", $datos['Direccion']);
        $sql->bindParam(":ID", $datos['ID']);
        $sql->execute();

        return $sql;
    }

}
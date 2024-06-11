<?php

require_once "mainModel.php";

class pedidoModelo extends mainModel{

    /*-------- Modelo agregar pedido --------*/
    protected static function agregar_pedido_modelo($datos){

        $sql = mainModel::conectar()->prepare("INSERT INTO pedido(codigo_pedido, cantidad_pedido, estado_pedido, fecha_pedido, id_client) VALUES(:Codigo, :Cantidad, :Estado, :Fecha, :Cliente)");
        
        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->bindParam(":Cantidad", $datos['Cantidad']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Fecha", $datos['Fecha']);
        $sql->bindParam(":Cliente", $datos['Cliente']);
        $sql->execute();

        return $sql;

    }

    /*-------- Modelo agregar detalle pedido --------*/
    protected static function agregar_detalle_pedido_modelo($datos){

        $sql = mainModel::conectar()->prepare("INSERT INTO detalle_pedido(cod_proc, producto_nombre, cantidad_detalle, pedido_codigo) VALUES(:COD, :Producto, :Cantidad, :Codigo)");
        
        $sql->bindParam(":COD", $datos['COD']);
        $sql->bindParam(":Producto", $datos['Producto']);
        $sql->bindParam(":Cantidad", $datos['Cantidad']);
        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->execute();

        return $sql;

    }

    /*-------- Modelo eliminar pedido --------*/
    protected static function eliminar_pedido_modelo($codigo){  
        $sql=mainModel::conectar()->prepare("DELETE FROM pedido WHERE codigo_pedido=:Codigo");

        $sql->bindParam(":Codigo", $codigo);
        $sql->execute();

        return $sql;

    }

    /*-------- Modelo datos pedido --------*/
    protected static function datos_pedido_modelo($tipo, $id){  
        if($tipo=="Unico"){
            $sql=mainModel::conectar()->prepare("SELECT * FROM pedido, detalle_pedido WHERE codigo_pedido=:ID AND codigo_pedido=pedido_codigo");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Conteo"){
            $sql=mainModel::conectar()->prepare("SELECT id_pedido FROM pedido ");
        }elseif($tipo=="Detalle"){
            $sql=mainModel::conectar()->prepare("SELECT * FROM  detalle_pedido WHERE pedido_codigo=:ID");
            $sql->bindParam(":ID", $id);
        }

        $sql->execute();

        return $sql;

    }

    /*-------- Modelo actualizar pedido --------*/
    protected static function actualizar_pedido_modelo($datos){

        $sql=mainModel::conectar()->prepare("UPDATE pedido SET estado_pedido=:Estado WHERE codigo_pedido=:Codigo ");

        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Codigo", $datos['Codigo']);
        
        $sql->execute();

        return $sql;

    }




}
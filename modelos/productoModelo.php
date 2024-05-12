<?php

require_once "mainModel.php";

class productoModelo extends mainModel{
        
        /*-------- Modelo agregar cliente --------*/
        protected static function agregar_producto_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO producto(codigo_producto, nombre_producto,descripcion_producto)VALUES(:Codigo, :NombreProducto,:DescripcionProducto)");
            
            $sql->bindParam(":Codigo", $datos['Codigo']);
            $sql->bindParam(":NombreProducto", $datos['NombreProducto']);
            $sql->bindParam(":DescripcionProducto", $datos['DescripcionProducto']);
            
            $sql->execute();
    
            return $sql;
    
        }

        /*-------- Modelo eliminar producto --------*/
        protected static function eliminar_producto_modelo($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM producto WHERE id_producto=:ID");
            
            $sql->bindParam(":ID", $id);
            $sql->execute();

            return $sql;
        }

        /*-------- Modelo datos producto --------*/
        protected static function datos_producto_modelo($tipo,$id){
            if($tipo=="Unico"){
                $sql=mainModel::conectar()->prepare("SELECT * FROM producto WHERE id_producto=:ID");
                $sql->bindParam(":ID",$id);
            }elseif($tipo=="Conteo"){
                $sql=mainModel::conectar()->prepare("SELECT id_producto FROM producto");
            }
            $sql->execute();
            return $sql;
        }

        /*-------- Modelo actualizar producto --------*/
        protected static function actualizar_producto_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE producto SET codigo_producto =:Codigo, nombre_producto=:NombreProducto, descripcion_producto=:DescripcionProducto WHERE id_producto=:ID ");
            $sql->bindParam(":Codigo", $datos['Codigo']);
            $sql->bindParam(":NombreProducto", $datos['NombreProducto']);
            $sql->bindParam(":DescripcionProducto", $datos['DescripcionProducto']);
            $sql->bindParam(":ID", $datos['ID']);
            
            $sql->execute();

            return $sql;
        }

}
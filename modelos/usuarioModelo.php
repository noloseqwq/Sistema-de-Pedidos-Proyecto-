<?php

require_once "mainModel.php";

class usuarioModelo extends mainModel{

    /*-------- Modelo agregar usuario --------*/
    protected static function agregar_usuario_modelo($datos){
        $conn=mainModel::conectar();
        
        try{   
            $sql = "INSERT INTO usuarios(usuario, email, clave, privilegio) VALUES(:Usuario, :EMAIL, :Clave, :Privilegio)";
            
            $result=$conn->prepare($sql);
            $result->bindParam(":Usuario", $datos['Usuario']);
            $result->bindParam(":EMAIL", $datos['EMAIL']);
            $result->bindParam(":Clave", $datos['Clave']);
            $result->bindParam(":Privilegio", $datos['Privilegio']);
            
            $result->execute();

            $lastid=$conn->lastInsertId();

            $sql = "INSERT INTO persona(nombre_persona, apellido_persona, CI_persona, id_usu) VALUES(:Nombre, :Apellido, :CI, :ID)";

            $result=$conn->prepare($sql);
            $result->bindParam(":Nombre", $datos['Nombre']);
            $result->bindParam(":Apellido", $datos['Apellido']);
            $result->bindParam(":CI", $datos['CI']);
            $result->bindParam(":ID", $lastid,  PDO::PARAM_INT);
            
            $result->execute();

        }catch(PDOException $e ){

            $resulta=$conn->rollBack();
            $result=$e;
        }
        return $result;
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
            $sql=mainModel::conectar()->prepare("SELECT * FROM usuarios, persona WHERE id_usuario=:ID AND id_usuario=id_usu");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Conteo"){
            $sql=mainModel::conectar()->prepare("SELECT id_usuario FROM usuarios WHERE id_usuario!=1");
        }
        $sql->execute();

        return $sql;
    }
    /*-------- Modelo actualizar datos usuario --------*/
    protected static function actualizar_usuario_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE usuarios INNER JOIN persona ON usuarios.id_usuario=persona.id_usu SET usuarios.usuario=:Usuario, persona.nombre_persona=:Nombre, persona.apellido_persona=:Apellido, persona.CI_persona=:CI, email=:EMAIL, clave=:Clave, privilegio=:Privilegio WHERE id_usuario=:ID ");

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

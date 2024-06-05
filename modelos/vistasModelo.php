<?php

    class vistasModelo{

        /*-------- Modelo para obtener vistas --------*/
        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca=["home","juego","client-list","client-new","client-search","client-update","client-order-list","order-new","order-search","order-update","product-list","product-new","product-search","product-update","user-list","user-new","user-search","user-update", "pending-order-list","placed-order-list"];
            if(in_array($vistas, $listaBlanca)){
                if(is_file("./vistas/contenidos/".$vistas."-CJ.php")){
                    $contenido ="./vistas/contenidos/".$vistas."-CJ.php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="login"){
                $contenido="login";
            }elseif($vistas=="recuperar"){
                $contenido="recuperar";
            }elseif($vistas=="presentacion"|| $vistas=="index"){
                $contenido="presentacion";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }
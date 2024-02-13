<?php

    class vistasModelo{

        /*-------- Modelo para obtener vistas --------*/
        protected static function obtener_vistas_modelo($vistas){
            $listaBlanca=["home","client-list","client-new","client-search","client-update","company","order-list","order-new","order-search","order-update","product-list","product-new","product-search","product-update","user-list","user-new","user-search","user-update"];
            if(in_array($vistas, $listaBlanca)){
                if(is_file("./vistas/contenidos/".$vistas."-CJ.php")){
                    $contenido ="./vistas/contenidos/".$vistas."-CJ.php";
                }else{
                    $contenido="404";
                }
            }elseif($vistas=="login"|| $vistas=="index"){
                $contenido="login";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }
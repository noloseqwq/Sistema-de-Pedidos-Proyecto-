<?php
    
    require_once "./modelos/vistasModelo.php";

    class vistasControlador extends vistasModelo{

        /*-------- Controlador obtener pantilla --------*/
        public function obtener_platilla_controlador(){
            return require_once "./vistas/pantilla.php";
        }

        /*-------- Controlador obtener vistas --------*/
        public function obtener_vistas_controlador(){
            if(isset($_GET['CJ'])){

            }else{

            }
            return $respuesta
        }

    }
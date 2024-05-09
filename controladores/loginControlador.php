<?php
    if($peticionAjax){
        require_once "../modelos/loginModelo.php"; 
    }else{
        require_once "./modelos/loginModelo.php";
    }

    class loginControlador extends loginModelo {

        /*--------Controlador para inciar sesion--------*/
        public function iniciar_sesion_controlador(){
            $usuario=mainModel::limpiar_cadena($_POST['usuario_log']);
            $clave=mainModel::limpiar_cadena($_POST['clave_log']);

            /*--------Comprobar los campos vacios--------*/
            if($usuario=="" || $clave==""){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "No has ingresados todos los datos",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }

            /*-------- Verificando integridad de los datos--------*/ 
            if(mainModel::verificar_datos("[a-zA-Z0-9]{3,35}",$usuario)){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "El Usuario no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{7,100}",$clave)){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "La clave no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }
            
            $clave=mainModel::encryption($clave);
            
            $datos_login=[
                "Usuario"=>$usuario,
                "Clave"=>$clave
            ];
            
            $datos_cuenta=loginModelo::iniciar_sesion_modelo($datos_login);
            

            if($datos_cuenta->rowCount()==1){
                $row=$datos_cuenta->fetch();

                session_start(['name' => 'SDP']);
                $_SESSION['id_sdp']=$row['id_usuario'];
                $_SESSION['nombre_sdp']=$row['nombre_persona'];
                $_SESSION['apellido_sdp']=$row['apellido_persona'];
                $_SESSION['usuario_sdp']=$row['usuario'];
                $_SESSION['privilegio_sdp']=$row['privilegio'];
                $_SESSION['token_sdp']=md5(uniqid(mt_rand(),true));

                return header("Location: ".SERVER_URL."home/");
            }else{
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "El Usuario o clave son incorrectos, Intente de nuevo",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }

        }/*Fin del controlador */

        /*--------Controlador para forzar cierre de sesion al sisrema--------*/
        public function forzar_cierre_sesion_controlador(){
            session_unset();
            session_destroy();
            if(headers_sent()){
                return "<script> window.location.href='".SERVER_URL."login/'; </script>";
            }else{ 
                return header("Location: ".SERVER_URL."login/");
            }
        }/*Fin del controlador */

        /*--------Controlador para  cierre de sesion al sisrema--------*/
        public function cerrar_sesion_controlador(){
            session_start(['name'=>'SDP']);
            $token=mainModel::decryption($_POST['token']);
            $usuario=mainModel::decryption($_POST['usuario']);

            if($token==$_SESSION['token_sdp'] && $usuario==$_SESSION['usuario_sdp']){
                session_unset();
                session_destroy();
                $alerta=[
                    "Alerta"=> "redireccionar",
                    "URL"=> SERVER_URL."presentacion/",
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se puedo cerrar la sesion",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            
        }/*Fin del controlador */
    }

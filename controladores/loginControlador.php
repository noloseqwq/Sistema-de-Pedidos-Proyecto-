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

        /*--------Controlador para forzar cierre de sesion al sistema--------*/
        public function forzar_cierre_sesion_controlador(){
            session_unset();
            session_destroy();
            if(headers_sent()){
                return "<script> window.location.href='".SERVER_URL."login/'; </script>";
            }else{ 
                return header("Location: ".SERVER_URL."login/");
            }
        }/*Fin del controlador */

        /*--------Controlador para  cierre de sesion al sistema--------*/
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
        
        /*--------Controlador comprobar usuario--------*/
        public function comprobar_usuario_controlador($dato){

            $usuario = mainModel::limpiar_cadena($dato);

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
            $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE usuario='$usuario'");


            if($check_user->rowCount() < 1){
                echo'<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "No se encontro al usuario en el sistema",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }
            return $check_user;
        }/*Fin del controlador */

        /*--------Controlador comprobar respuesta--------*/

        public function comprobar_respuesta_controlador($datos){
            $respuesta1=mainModel::limpiar_cadena($datos['Respuesta1']);
            $respuesta2=mainModel::limpiar_cadena($datos['Respuesta2']);
            $usuario=mainModel::limpiar_cadena($datos['Usuario']);

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}",$respuesta1)){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "La respuesta N°1 no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}",$respuesta2)){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "La respuesta N°2 no coincide con el formato solicitado",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }

            
            $check_respuesta=mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios WHERE usuario='$usuario' AND respuesta1='$respuesta1' AND respuesta2='$respuesta2'");

            if($check_respuesta->rowCount() < 1){
                echo '<script>
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "Alguna de las respuestas es incorectas",
                    type: "error",
                    confirmButtonText: "Aceptar"
                });
                </script>';
                exit();
            }

            return $check_respuesta;

        }/*Fin del controlador */

        /*--------Controlador actualizar clave--------*/
        public function recuperar_clave_controlador(){
            $usuario = mainModel::limpiar_cadena($_POST['usuario_rec']);
            $clave = mainModel::limpiar_cadena($_POST['clave_rec']);

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

            $datos=[
                "Usuario" => $usuario,
                "Clave" => $clave
            ];

            $actualizacion=loginModelo::recuperar_clave_modelo($datos);

            if($actualizacion->rowCount()==1){
                echo'<script>
                
                Swal.fire({
                    title:"Actualizacion Exitosa",
                    text: "La actualizacion de la contraseña a sido exitosa",
                    type: "success",
                    confirmButtonText: "Aceptar",
                }).then((result) => {
                    if (result.value) {
                        window.location.href ="'.SERVER_URL.'login"
                    }
                });
                
                
                </script>';

            }

            

        }
    
    }

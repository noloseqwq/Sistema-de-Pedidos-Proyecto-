<?php

    if($peticionAjax){
        require_once "../modelos/usuarioModelo.php"; 
    }else{
        require_once "./modelos/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo {

        /*-------- Controlador agregar usuario --------*/
        public function agregar_usuario_controlador(){
            $CI=mainModel::limpiar_cadena($_POST['usuario_CI_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_reg']);
            $clave1=mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
            $clave2=mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
            
            $privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);
        
        /*-------- comprobar campos vacios --------*/
        
            if($CI == "" || $nombre == "" || $apellido == "" ||$usuario == "" ||$email == "" ||$clave1 == "" || $clave2 == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Por favor rellene los campos faltantes",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Verificando integridad de los datos --------*/
            if(mainModel::verificar_datos("[0-9-]{6,20}",$CI)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La Cedúla de indentidad no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,35}",$nombre)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Nombre no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,35}",$apellido)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Apellido no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9]{3,35}",$usuario)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Nombre de Usuario no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{7,100}",$clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{7,100}",$clave2) ){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"las Claves no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando C.I --------*/
            $check_CI = mainModel::ejecutar_consulta_simple("SELECT CI FROM usuarios WHERE CI='$CI'" );
            if($check_CI->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Numero de Cedúla que ha ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /*-------- Comprobando Usuario --------*/
            
            $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM usuarios WHERE usuario='$usuario'" );
            if($check_user->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Usuario que ha ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            } 

            /*-------- Comprobando Email --------*/
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM usuarios WHERE email='$email'" );
                if($check_email->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"El Email que ha ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Ha ingresado un correo no valido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando claves --------*/
            if($clave1!=$clave2){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Las claves no coiciden",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $clave=mainModel::encryption($clave1);
            }

            /*-------- Comprobando Privlegio --------*/

            if($privilegio<1 || $privilegio>3){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Privilegio que a seleccionado no es valido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            } 

            $datos_usuario_reg=[
                "Usuario"=>$usuario,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "CI"=>$CI,
                "EMAIL"=>$email,
                "Clave"=>$clave,
                "Privilegio"=>$privilegio,
            ];

            $agregar_usuario= usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);
            if($agregar_usuario->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Usuario registrado",
                    "Texto"=>"Los datos usuario han sido registrado con excito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en el registro de los datos del Usuario",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        }/* Fin de del controlador */
    }
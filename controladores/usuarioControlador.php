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

        /*-------- Controlador paginar usuario --------*/
        public function paginador_usuario_controlador($pagina,$registros, $privilegio, $id,$url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $id=mainModel::limpiar_cadena($id);

            $url=mainModel::limpiar_cadena($url);
            $url=SERVER_URL.$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
            $tabla="";
            
            //Operador ternario que funciona como una condicional doble
            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE ((id_usuario!='$id' AND id_usuario!='1')AND (CI LIKE '%$busqueda%' OR usuario LIKE '%$busqueda%' OR email LIKE '%$busqueda%')) ORDER BY nombre ASC LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuarios WHERE id_usuario!='$id' AND id_usuario!='1' ORDER BY nombre ASC LIMIT $inicio, $registros";
            }

            $conexion= mainModel::conectar();

            $datos= $conexion->query($consulta);

            $datos= $datos-> fetchAll();

            $total= $conexion->query("SELECT FOUND_ROWS()");
            $total= (int) $total->fetchColumn();

            $Npaginas= ceil($total/$registros);

            $tabla.='<div class="table-responsive">
            <table class="table table-dark table-sm">
                <thead>
                    <tr class="text-center roboto-medium">
                        <th>#</th>
                        <th>DNI</th>
                        <th>NOMBRE</th>
                        <th>USUARIO</th>
                        <th>EMAIL</th>
                        <th>ACTUALIZAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody>';
            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $reg_inicio=$inicio+1;
                foreach($datos as $rows){
                    $tabla.='<tr class="text-center">
                    <td>'.$contador.'</td>
                    <td>'.$rows['CI'].'</td>
                    <td>'.$rows['nombre'].' '.$rows['apellido'].'</td>

                    <td>'.$rows['usuario'].'</td>
                    <td>'.$rows['email'].'</td>
                    <td>
                        <a href="'.SERVER_URL.'user-update/'.mainModel::encryption($rows['id_usuario']).'/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>
                    <td>
                        <form class="FormularioAjax" action="'.SERVER_URL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="id_usuario_del" value="'.mainModel::encryption($rows['id_usuario']).'">
                            <button type="submit" class="btn btn-warning">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>';
                $contador++;
                }
                $reg_final=$contador-1;
            }else{
                if($total>=1){
                    $tabla.='<tr class="text-center"> <td colspan="7">
                    <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado</a>
                    </td> </tr>';
                }else{

                    $tabla.='<tr class="text-center"> <td colspan="9">No hay resgistros en el sistema</td> </tr>';
                }
            }
            $tabla.='</tbody>
                    </table>
                    </div>';
            if($total>=1 && $pagina<=$Npaginas){
                $tabla.='<p class=" text-right">Mostrando Usuarios '. $reg_inicio.' al '.$reg_final.' de un total de '. $total .' </p>';
            }
            if($total>=1 && $pagina<=$Npaginas){
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */

    }
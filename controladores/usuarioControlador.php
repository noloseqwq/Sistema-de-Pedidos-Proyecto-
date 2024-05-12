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
            if(mainModel::verificar_datos("[0-9\-]{6,20}",$CI)){
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
            if(mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{8,100}",$clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{8,100}",$clave2) ){
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
            $check_CI = mainModel::ejecutar_consulta_simple("SELECT CI_persona FROM persona WHERE CI_persona='$CI'" );
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
            if($agregar_usuario==true){
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
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuarios, persona WHERE ((id_usuario!='$id' AND id_usuario!='1')AND (id_usuario=id_usu) AND (CI_persona LIKE '%$busqueda%' OR usuario LIKE '%$busqueda%' OR email LIKE '%$busqueda%')) ORDER BY nombre_persona ASC LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM usuarios, persona WHERE id_usuario!='$id' AND id_usuario!='1' AND id_usuario=id_usu ORDER BY nombre_persona ASC LIMIT $inicio, $registros";
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
                        <th>CEDÚLA</th>
                        <th>NOMBRE Y APELLIDO</th>
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
                    <td>'.$rows['CI_persona'].'</td>
                    <td>'.$rows['nombre_persona'].' '.$rows['apellido_persona'].'</td>

                    <td>'.$rows['usuario'].'</td>
                    <td>'.$rows['email'].'</td>
                    <td>
                        <a href="'.SERVER_URL.'user-update/'.mainModel::encryption($rows['id_usuario']).'/" class="btn btn-success">
                        <i class="fas fa-edit"></i>
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
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */

        /*-------- Controlador eliminar usuario --------*/
        public function eliminar_usuario_controlador(){
            
            /* recibiendo id del usuario*/
            $id=mainModel::decryption($_POST['id_usuario_del']);
            $id=mainModel::limpiar_cadena($id);

            /* comprobando el usuario principal*/
            if($id==1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se puede eliminar el usuario principal del sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /* comprobando el usuario en BD*/
            $check_usuario = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE id_usuario='$id'");
            if($check_usuario->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El usuario que intenta eliminar no existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /* comprobando privilegios */
            session_start(['name'=> 'SDP']);
            if($_SESSION['privilegio_sdp']!=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No tienes Autorizacion para eliminar usuarios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_usuario= usuarioModelo::eliminar_usuario_modelo($id);

            if($eliminar_usuario-> rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Usuario Eliminado",
                    "Texto"=>"El usuario ha sido eliminado",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se a podido eliminar el usuario",
                    "Tipo"=>"error"
                ];
                
            }
            echo json_encode($alerta);


        }/* Fin de del controlador */

            /*-------- Controlador datos usuario --------*/
        public static function datos_usuario_controlador($tipo,$id){
            $tipo=mainModel::limpiar_cadena($tipo);

            $id=mainModel::decryption($id);
            $id=mainModel::limpiar_cadena($id);
            
            return usuarioModelo::datos_usuario_modelo($tipo,$id);
        }/* Fin de del controlador */   

            /*-------- actualizar datos usuario --------*/
        public static function actualizar_usuario_controlador(){
            
            //Recibiendo id
            $id=mainModel::decryption($_POST['id_usuario_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el usuario en la BD
            $check_user=mainModel::ejecutar_consulta_simple("SELECT * FROM usuarios, persona WHERE id_usuario=id_usu AND id_usuario='$id' ");

            if($check_user->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos encontrado el usuario en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_user->fetch();
            }
            
            $CI=mainModel::limpiar_cadena($_POST['usuario_CI_up']);
            $nombre=mainModel::limpiar_cadena($_POST['usuario_nombre_up']);
            $apellido=mainModel::limpiar_cadena($_POST['usuario_apellido_up']);
            
            $usuario=mainModel::limpiar_cadena($_POST['usuario_usuario_up']);
            $email=mainModel::limpiar_cadena($_POST['usuario_email_up']);

            $pregunta1=mainModel::limpiar_cadena($_POST['usuario_pregunta1_up']);
            $pregunta2=mainModel::limpiar_cadena($_POST['usuario_pregunta2_up']);
            $respuesta1=mainModel::limpiar_cadena($_POST['usuario_respuesta1_up']);
            $respuesta2=mainModel::limpiar_cadena($_POST['usuario_respuesta2_up']);

            

            if(isset($_POST['usuario_privilegio_up'])){
                $privilegio=mainModel::limpiar_cadena($_POST['usuario_privilegio_up']);
            }else{
                $privilegio=$campos['privilegio'];
            }

            $admin_usuario=mainModel::limpiar_cadena($_POST['usuario_admin']);
            $admin_clave=mainModel::limpiar_cadena($_POST['clave_admin']);

            $tipo_cuenta=mainModel::limpiar_cadena($_POST['tipo_cuenta']);

            /*-------- comprobar campos vacios --------*/
        
            if($CI == "" || $nombre == "" || $apellido == "" ||$usuario == "" ||$email == "" || $admin_usuario== "" || $admin_clave== "" ){
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

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{7,100}",$pregunta1)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La pregunta N°1 no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{7,100}",$pregunta2)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La pregunta N°2 no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}",$respuesta1)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La respuesta N°1 no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ?]{3,100}",$respuesta2)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La respuesta N°2 no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            
            if(mainModel::verificar_datos("[a-zA-Z0-9]{3,35}",$admin_usuario)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Tu Nombre de Usuario no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            if(mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{7,100}",$admin_clave)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Tu Clave no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $admin_clave=mainModel::encryption($admin_clave);

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
            /*-------- Comprobando C.I --------*/
            if($CI!=$campos['CI_persona']){
                $check_CI = mainModel::ejecutar_consulta_simple("SELECT CI_persona FROM persona WHERE CI_persona='$CI'" );
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
            }
            
            /*-------- Comprobando Usuario --------*/
            if($usuario!=$campos['usuario']){
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
            }

            /*-------- Comprobando email --------*/
            if($email!=$campos['email'] && $email!=""){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $check_email = mainModel::ejecutar_consulta_simple("SELECT email FROM usuarios WHERE email='$email'" );
                    if($check_email->rowCount()>0){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"ocurrio un error inesperado",
                            "Texto"=>"El nuevo EMAIL que ha ingresado ya se encuentra registrado en el sistema",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    } 
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"Ha ingresado un EMAIL no valido",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }

            }
            /*-------- Comprobando claves --------*/
            if($_POST['usuario_clave_1_up']!="" || $_POST['usuario_clave_2_up']!=""){
                if($_POST['usuario_clave_1_up']!=$_POST['usuario_clave_2_up']){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"Las Nuevas claves no coinciden",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }else{
                    if(mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{8,100}",$_POST['usuario_clave_1_up']) || mainModel::verificar_datos("[a-zA-Z0-9$@.\-]{8,100}",$_POST['usuario_clave_2_up']) ){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"ocurrio un error inesperado",
                            "Texto"=>"las nuevas Claves no coincide con el formato solicitado",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                    $clave=mainModel::encryption($_POST['usuario_clave_1_up']);
                }
            }else{
                $clave=$campos['clave'];
            }

            /*-------- Comprobando credenciales para actualizar datos --------*/
            if($tipo_cuenta=="Propia"){
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario='$admin_usuario' AND clave='$admin_clave' AND id_usuario='$id'" );
            }else{
                session_start(['name'=>'SDP']);
                if($_SESSION['privilegio_sdp']!=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"No tienes los Permisos necesarios para realizar esta operacion",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
                $check_cuenta = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM usuarios WHERE usuario='$admin_usuario' AND clave='$admin_clave'" );
            }
            if($check_cuenta->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Nombre y clave de administrador no valido ",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*-------- Preparando datos para enviarlos al modelo --------*/
            
            $datos_usuario_up=[
                "Usuario"=>$usuario,    
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "CI"=>$CI,
                "EMAIL"=>$email,
                "Clave"=>$clave,
                "Privilegio"=>$privilegio,
                "Pregunta1" =>$pregunta1,
                "Pregunta2" =>$pregunta2,
                "Respuesta1" =>$respuesta1,
                "Respuesta2" =>$respuesta2,
                "ID"=>$id
            ];

            if(usuarioModelo::actualizar_usuario_modelo($datos_usuario_up)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Datos actualizados",
                    "Texto"=>"Los Datos han sido actualizados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Los datos no se han podido actualizar",
                    "Tipo"=>"error"
                ];
                
            }
            echo json_encode($alerta); 
        }/* Fin de del controlador */
        
    }
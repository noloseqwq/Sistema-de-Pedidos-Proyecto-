<?php

    if($peticionAjax){
        require_once "../modelos/clienteModelo.php"; 
    }else{
        require_once "./modelos/clienteModelo.php";
    }

    class clienteControlador extends clienteModelo {

        /*-------- Controlador agregar cliente --------*/
        public function agregar_cliente_controlador(){
            $RIF=mainModel::limpiar_cadena($_POST['cliente_RIF_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $razon=mainModel::limpiar_cadena($_POST['cliente_razon_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

            /*-------- comprobar campos vacios --------*/
        
            if($RIF == "" ||$telefono == "" ||$razon == "" ||$direccion == "" ){
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
            if(mainModel::verificar_datos("[0-9\-]{6,20}",$RIF)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La Cedúla de indentidad no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[0-9\-]{11,12}",$telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Número de telefono no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}",$razon)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}",$direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La Cedúla de indentidad no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando RIF --------*/
            $check_RIF = mainModel::ejecutar_consulta_simple("SELECT cliente_rif FROM cliente WHERE cliente_rif='$RIF'" );
            if($check_RIF->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Numero de Cedúla que ha ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /*-------- Comprobando Telfono --------*/
            $check_tlf = mainModel::ejecutar_consulta_simple("SELECT cliente_tlf FROM cliente WHERE cliente_tlf='$telefono'" );
            if($check_tlf->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Numero de Telefono que ha ingresado ya se encuentra registrado en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_cliente_reg=[
                "RIF"=>$RIF,
                "TLF"=>$telefono,
                "Razon"=>$razon,
                "Direccion"=>$direccion
            ];

            $agregar_cliente=clienteModelo::agregar_cliente_modelo($datos_cliente_reg);
            if($agregar_cliente->rowCount()==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Cliente registrado",
                    "Texto"=>"Los datos del cliente han sido registrado con excito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en el registro de los datos del cliente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
            
        }/*Fin del cotrolador*/

        /*-------- Controlador paginar cliente --------*/
        public function paginador_cliente_controlador($pagina,$registros, $privilegio, $url,$busqueda){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            $url=mainModel::limpiar_cadena($url);
            $url=SERVER_URL.$url."/";

            $busqueda=mainModel::limpiar_cadena($busqueda);
            $tabla="";
            
            //Operador ternario que funciona como una condicional doble
            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT * FROM cliente WHERE cliente_razon LIKE '%$busqueda%' OR cliente_rif LIKE '%$busqueda%' OR cliente_tlf LIKE '%$busqueda%' ORDER BY cliente_rif ASC LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_rif ASC LIMIT $inicio, $registros";
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
                        <th>RIF</th>
                        <th>RAZÓN SOCIAL</th>
                        <th>TELEFONO</th>
                        <th>DIRECCIÓN</th>';
                        
                        if($privilegio == 1 || $privilegio == 2){
                            $tabla.='<th>ACTUALIZAR</th>';
                        }
                        if($privilegio == 1 ){
                            $tabla.='<th>ELIMINAR</th>';
                        }
                        

                    $tabla.='</tr>
                </thead>
                <tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                $reg_inicio=$inicio+1;
                foreach($datos as $rows){
                    $tabla.='<tr class="text-center">
                    <td>'.$contador.'</td>
                    <td>'.$rows['cliente_rif'].'</td>
                    <td>'.$rows['cliente_razon'].'</td>

                    <td>'.$rows['cliente_tlf'].'</td>
                    <td>'.$rows['cliente_direccion'].'</td>';

                    if($privilegio == 1 || $privilegio == 2){
                        $tabla.='<td>
                        <a href="'.SERVER_URL.'client-update/'.mainModel::encryption($rows['id_cliente']).'/" class="btn btn-success">
                        <i class="fas fa-edit"></i>
                        </a>
                    </td>';
                    }
                    if($privilegio == 1 ){
                        $tabla.='<td>
                        <form class="FormularioAjax" action="'.SERVER_URL.'ajax/clienteAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="id_cliente_del" value="'.mainModel::encryption($rows['id_cliente']).'">
                            <button type="submit" class="btn btn-warning">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                        </td>';
                    }
                
                    
                    
                $tabla.='</tr>';
                $contador++;
                }
                $reg_final=$contador-1;
            }else{
                if($total>=1){
                    $tabla.='<tr class="text-center"> <td colspan="6">
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
                $tabla.='<p class=" text-right">Mostrando clientes '. $reg_inicio.' al '.$reg_final.' de un total de '. $total .' </p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */
        
        /*-------- Controlador eliminar cliente --------*/
        public function eliminar_cliente_controlador(){
            
            //Recuperar id del cliente
            $id=mainModel::decryption($_POST['id_cliente_del']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el cliente en la BD
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT id_cliente FROM cliente WHERE id_cliente='$id'");
            if($check_cliente->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Cliente que intenta eliminar no existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            //Comprobar prestamos
            $check_pedidos= mainModel::ejecutar_consulta_simple("SELECT id_cliente FROM pedido WHERE id_cliente='$id' LIMIT 1");
            if($check_pedidos->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Cliente que intenta eliminar tiene un pedido pendiente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            } 

            // comprobar los  privilegios
            session_start(['name' => 'SDP']);
            if($_SESSION['privilegio_sdp'] != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No tienes los permisos necesarios para eliminar un cliente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_cliente=clienteModelo::eliminar_cliente_modelo($id);

            if($eliminar_cliente->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cliente Eliminado",
                    "Texto"=>"El cliente ha sido eliminado de manera excitosa",
                    "Tipo"=>"success"
                ];
                
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>">No se pudo eleminar el cliente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);

        }/* Fin de del controlador */
        
        /*-------- Controlador datos cliente --------*/
        public function datos_cliente_controlador($tipo,$id){
            $tipo= mainModel::limpiar_cadena($tipo);

            $id=mainModel::decryption($id);
            $id=mainModel::limpiar_cadena($id);

            return clienteModelo::datos_cliente_modelo($tipo,$id);
        }/* Fin de del controlador */

        /*-------- Controlador actualizar cliente --------*/
        public function actualizar_cliente_controlador(){
            //Recuperar ID
            $id=mainModel::decryption($_POST['id_cliente_up']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el cliente en la BD
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE id_cliente='$id'");
            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se ha encontrado al cliente",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_cliente->fetch();
            }

            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_up']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_up']);

            if($telefono == "" || $direccion ==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No ha llenado los campos obligatorios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*-------- Verificando integridad de los datos --------*/
            if(mainModel::verificar_datos("[0-9\-]{6,20}",$telefono)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Número de telefono no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{5,50}",$direccion)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La Cedúla de indentidad no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /*-------- Comprobando Telfono --------*/
            if($telefono!=$campos['cliente_tlf']){
                $check_tlf = mainModel::ejecutar_consulta_simple("SELECT cliente_tlf FROM cliente WHERE cliente_tlf='$telefono'" );
                if($check_tlf->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"El Numero de Telefono que ha ingresado ya se encuentra registrado",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            //Comprobando privilegios 
            session_start(['name' => 'SDP']);
            if($_SESSION['privilegio_sdp'] < 1 || $_SESSION['privilegio_sdp'] > 2){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"No cuentas con los privilegios necesarios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_cliente_up=[
                "TLF"=>$telefono,
                "Direccion"=>$direccion,
                "ID"=>$id
            ];

            $actualizar_cliente=clienteModelo::actualizar_cliente_modelo($datos_cliente_up);
            if($actualizar_cliente->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cliente Actualizado",
                    "Texto"=>"Los datos del cliente han sido actualizado con excito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en la actualizacion de los datos del cliente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);


        
        }/* Fin de del controlador */
    }

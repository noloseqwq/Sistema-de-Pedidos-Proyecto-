<?php

    if($peticionAjax){
        require_once "../modelos/clienteModelo.php"; 
    }else{
        require_once "./modelos/clienteModelo.php";
    }

    class clienteControlador extends clienteModelo {

        /*-------- Controlador agregar cliente --------*/
        public function agregar_cliente_controlador(){
            $CI=mainModel::limpiar_cadena($_POST['cliente_CI_reg']);
            $nombre=mainModel::limpiar_cadena($_POST['cliente_nombre_reg']);
            $apellido=mainModel::limpiar_cadena($_POST['cliente_apellido_reg']);
            $telefono=mainModel::limpiar_cadena($_POST['cliente_telefono_reg']);
            $razon=mainModel::limpiar_cadena($_POST['cliente_razon_reg']);
            $direccion=mainModel::limpiar_cadena($_POST['cliente_direccion_reg']);

            /*-------- comprobar campos vacios --------*/
        
            if($CI == "" || $nombre == "" || $apellido == "" ||$telefono == "" ||$razon == "" ||$direccion == "" ){
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

            /*-------- Comprobando C.I --------*/
            $check_CI = mainModel::ejecutar_consulta_simple("SELECT cliente_CI FROM cliente WHERE cliente_CI='$CI'" );
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
                "CI"=>$CI,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
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
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente WHERE cliente_CI LIKE '%$busqueda%' OR cliente_nombre LIKE '%$busqueda%' OR cliente_tlf LIKE '%$busqueda%' ORDER BY cliente_CI ASC LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM cliente ORDER BY cliente_CI ASC LIMIT $inicio, $registros";
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
                    <td>'.$rows['cliente_CI'].'</td>
                    <td>'.$rows['cliente_nombre'].' '.$rows['cliente_apellido'].'</td>

                    <td>'.$rows['cliente_tlf'].'</td>
                    <td>'.$rows['cliente_direccion'].'</td>';

                    if($privilegio == 1 || $privilegio == 2){
                        $tabla.='<td>
                        <a href="'.SERVER_URL.'client-update/'.mainModel::encryption($rows['id_cliente']).'/" class="btn btn-success">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </td>';
                    }
                    if($privilegio == 1 ){
                        $tabla.='<td>
                        <form class="FormularioAjax" data-form="delete" autocomplete="off">
                        <input type="hidden" name="id_cliente_del" value="'.mainModel::encryption($rows['id_cliente']).'">
                            <button tyoAjax" action="'.SERVER_URL.'ajax/clienteAjax.php" method="POSTpe="submit" class="btn btn-warning">
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


    }

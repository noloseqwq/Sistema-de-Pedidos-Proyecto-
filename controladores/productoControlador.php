<?php

    if($peticionAjax){
        require_once "../modelos/productoModelo.php"; 
    }else{
        require_once "./modelos/productoModelo.php";
    }

    class productoControlador extends productoModelo {
        
        /*-------- controlador agregar Producto --------*/
        public function agregar_producto_controlador(){

            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_reg']);
            $nombreProducto=mainModel::limpiar_cadena($_POST['producto_nombre_reg']);
            $descripcionProducto=mainModel::limpiar_cadena($_POST['producto_detalle_reg']);

            /*-------- comprobar campos vacios --------*/
            if($codigo == "" || $nombreProducto == ""){
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
            if(mainModel::verificar_datos("[A-Z0-9]{3,6}",$codigo)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{14,100}",$nombreProducto)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($descripcionProducto!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{1,190}",$descripcionProducto)){
                                $alerta=[
                                    "Alerta"=>"simple",
                                    "Titulo"=>"ocurrio un error inesperado",
                                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                                    "Tipo"=>"error"
                                ];
                                echo json_encode($alerta);
                                exit();
                            }

            }
            
        

            /*-------- Comprobando Codigo --------*/
            $check_codigo = mainModel::ejecutar_consulta_simple("SELECT codigo_producto FROM producto WHERE codigo_producto='$codigo'" );
            if($check_codigo->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Codigo que ha ingresado ya existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando Nombre --------*/
            $check_nombre = mainModel::ejecutar_consulta_simple("SELECT nombre_producto FROM producto WHERE nombre_producto='$nombreProducto'" );
            if($check_nombre->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Nombre que ha ingresado ya existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $datos_producto_reg=[
                "Codigo" => $codigo,
                "NombreProducto" => $nombreProducto ,
                "DescripcionProducto" => $descripcionProducto
            ];

            $agregar_producto=productoModelo::agregar_producto_modelo($datos_producto_reg);
            if($agregar_producto->rowCount() ==1){
                $alerta=[
                    "Alerta"=>"limpiar",
                    "Titulo"=>"Producto registrado",
                    "Texto"=>"Los datos del Producto han sido registrado con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en el registro de los datos del Producto",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);


        }/* Fin del controlador  */

        /*-------- Controlador paginar productos --------*/
        public function paginador_producto_controlador($pagina,$registros, $privilegio, $url,$busqueda){
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
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM producto WHERE codigo_producto LIKE '%$busqueda%' OR nombre_producto LIKE '%$busqueda%' ORDER BY codigo_producto DESC LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT  * FROM producto ORDER BY codigo_producto DESC LIMIT $inicio, $registros";
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
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCION</th>';
                        
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
                    <td>'.$rows['codigo_producto'].'</td>
                    <td>'.$rows['nombre_producto'].'</td>

                    <td>'.$rows['descripcion_producto'].'</td>';

                    if($privilegio == 1 || $privilegio == 2){
                        $tabla.='<td>
                        <a href="'.SERVER_URL.'product-update/'.mainModel::encryption($rows['id_producto']).'/" class="btn btn-success">
                        <i class="fas fa-edit"></i>
                        </a>
                    </td>';
                    }
                    if($privilegio == 1 ){
                        $tabla.='<td>
                        <form class="FormularioAjax" action="'.SERVER_URL.'ajax/productoAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="id_producto_del" value="'.mainModel::encryption($rows['id_producto']).'">
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
                    $tabla.='<tr class="text-center"> <td colspan="7">
                    <a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic aca para recargar el listado</a>
                    </td> </tr>';
                }else{

                    $tabla.='<tr class="text-center"> <td colspan="7">No hay resgistros en el sistema</td> </tr>';
                }
            }
            $tabla.='</tbody>
                    </table>
                    </div>';

            if($total>=1 && $pagina<=$Npaginas){
                $tabla.='<p class=" text-right">Mostrando productos '. $reg_inicio.' al '.$reg_final.' de un total de '. $total .' </p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */
        
        /*-------- Controlador eliminar producto --------*/
        public function eliminar_producto_controlador(){
            
            //Recuperar id del producto
            $id=mainModel::decryption($_POST['id_producto_del']);
            $id=mainModel::limpiar_cadena($id);

            //Comprobar el producto en la BD
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT id_producto FROM producto WHERE id_producto='$id'");
            if($check_producto->rowCount() <= 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El Producto que intenta eliminar no existe en el sistema",
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
                    "Texto"=>"No tienes los permisos necesarios para eliminar un producto",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_producto=productoModelo::eliminar_producto_modelo($id);

            if($eliminar_producto->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Producto Eliminado",
                    "Texto"=>"El Producto ha sido eliminado de manera exitosa",
                    "Tipo"=>"success"
                ];
                
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>">No se pudo eleminar el producto",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);

        }/* Fin de del controlador */
        
        /*-------- Controlador datos producto --------*/
        public function datos_producto_controlador($tipo,$id){
            $tipo= mainModel::limpiar_cadena($tipo);

            $id=mainModel::decryption($id);
            $id=mainModel::limpiar_cadena($id);

            return productoModelo::datos_producto_modelo($tipo,$id);
        }/* Fin de del controlador */

                /*-------- Controlador actualizar producto --------*/
        public function actualizar_producto_controlador(){
            //Recuperar ID
            $id=mainModel::decryption($_POST['id_producto_up']);
            $id=mainModel::limpiar_cadena($id);
            
            //Comprobar el producto en la BD
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE id_producto='$id'");
            if($check_producto->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se ha encontrado al producto",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_producto->fetch();
            }
            
            $codigo=mainModel::limpiar_cadena($_POST['producto_codigo_up']);
            $nombreProducto=mainModel::limpiar_cadena($_POST['producto_nombre_up']);
            $descripcionProducto=mainModel::limpiar_cadena($_POST['producto_detalle_up']);

            /*-------- comprobar campos vacios --------*/
            if($codigo == "" || $nombreProducto == ""){
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
            if(mainModel::verificar_datos("[A-Z0-9]{3,6}",$codigo)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{14,100}",$nombreProducto)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($descripcionProducto!=""){
                if(mainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,#\- ]{1,190}",$descripcionProducto)){
                                $alerta=[
                                    "Alerta"=>"simple",
                                    "Titulo"=>"ocurrio un error inesperado",
                                    "Texto"=>"El Codigo del Producto no coincide con el formato solicitado",
                                    "Tipo"=>"error"
                                ];
                                echo json_encode($alerta);
                                exit();
                            }

            }
            
            
            /*-------- Comprobando Codigo --------*/
            if($codigo != $campos['codigo_producto']){
                $check_codigo = mainModel::ejecutar_consulta_simple("SELECT codigo_producto FROM producto WHERE codigo_producto='$codigo'" );
                if($check_codigo->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"El Codigo que ha ingresado ya existe en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
            

            /*-------- Comprobando Nombre --------*/
            if($nombreProducto != $campos['nombre_producto']){
                $check_nombre = mainModel::ejecutar_consulta_simple("SELECT nombre_producto FROM producto WHERE nombre_producto='$nombreProducto'" );
                if($check_nombre->rowCount()>0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"ocurrio un error inesperado",
                        "Texto"=>"El Nombre que ha ingresado ya existe en el sistema",
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

            $datos_producto_up=[
                "Codigo" => $codigo,
                "NombreProducto" => $nombreProducto ,
                "DescripcionProducto" => $descripcionProducto,
                "ID"=> $id 
            ];

            $actualizar_producto=productoModelo::actualizar_producto_modelo($datos_producto_up);
            if($actualizar_producto->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"producto Actualizado",
                    "Texto"=>"Los datos del producto han sido actualizado con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en la actualizacion de los datos del producto",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);


        
        }/* Fin de del controlador */

    }
<?php

    if($peticionAjax){
        require_once "../modelos/pedidoModelo.php"; 
    }else{
        require_once "./modelos/pedidoModelo.php";
    }

    class pedidoControlador extends pedidoModelo {

        /*-------- controlador buscar Cliente Pedido --------*/
        public function buscar_cliente_pedido_controlador() {
            
            /*-------- recuperar el texto --------*/
            $cliente=mainModel::limpiar_cadena($_POST['buscar_cliente']);
            
            /*-------- Comprobar campo vacio --------*/
            
            if($cliente == ""){
                return '<div class="alert alert-warning" role="alert">
                <p class="text-center mb-0">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                Debes introducir el RIF, Razon social o Telefono 
                </p>
                </div>';
                exit();
            }
            /*-------- Selecionando clientes en la BD --------*/
            
            $datos_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE cliente_rif LIKE '%$cliente%' OR cliente_tlf LIKE '%$cliente%' OR cliente_razon LIKE '%$cliente%' ORDER BY  cliente_rif DESC ");
            
            if($datos_cliente->rowCount() >= 1  ){
                $datos_cliente= $datos_cliente->fetchAll();
                
                $tabla='
                <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm">
                <tbody>
                ';
                
                foreach( $datos_cliente as $rows){
                    $tabla.='
                    <tr class="text-center">
                    <td>'.$rows['cliente_rif'].'  -  '.$rows['cliente_razon'].'</td>
                    <td>
                    <button type="button" class="btn btn-primary" onclick="agregar_cliente('.$rows['id_cliente'].')" ><i class="fas fa-user-plus"></i></button>
                    </td>
                    </tr>
                    ';
                }
                
                
                
                $tabla.='
                </tbody>
                </table>
                </div>
                ';
                return $tabla;
            }else{
                return '<div class="alert alert-warning" role="alert">
                <p class="text-center mb-0">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$cliente.'”</strong>
                </p>
                </div>';
                exit();
            }
            
        } /* fin del controlador */
        
        /*-------- controlador agregar Cliente Pedido --------*/
        public function agregar_cliente_pedido_controlador(){

            /*-------- recuperar el id --------*/
            $id=mainModel::limpiar_cadena($_POST['id_agregar_cliente']);

            /*-------- comprobando el clientes en la BD --------*/
            
            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT * FROM cliente WHERE id_cliente='$id'");

            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos encontrado al cliente en el sistema ",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_cliente->fetch();
            }

            /*-------- Iniciando la sesion --------*/
            session_start(['name' => 'SDP']);
            
            if(empty($_SESSION['datos_cliente'])){
                $_SESSION['datos_cliente']=[
                    "ID"=>$campos['id_cliente'],
                    "RIF"=>$campos['cliente_rif'],
                    "Razon"=>$campos['cliente_razon'],
                ];
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cliente Agregado",
                    "Texto"=>"El cliente se agrego al pedido",
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido agregar al cliente al pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                
            }
            
            
        } /* fin del controlador */

        /*-------- Controlador eliminar cliente Pedido --------*/
        public function eliminar_cliente_pedido_controlador(){

            //Inicando Sesion 
            session_start(['name' => 'SDP']);

            unset($_SESSION['datos_cliente']);

            if(empty($_SESSION['datos_cliente'])){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Datos removidos",
                    "Texto"=>"Los datos del cliente han sido removidos del pedido",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido remover los datos del cliente",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);


        }/* Fin de del controlador */

        /*-------- Controlador buscar producto Pedido --------*/
        public function buscar_producto_pedido_controlador(){
            
            /*-------- recuperar el texto --------*/
            $producto=mainModel::limpiar_cadena($_POST['buscar_producto']);
            
            /*-------- Comprobar campo vacio --------*/
            
            if($producto == ""){
                return '<div class="alert alert-warning" role="alert">
                <p class="text-center mb-0">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                Debes introducir el codigo o nombre del producto 
                </p>
                </div>';
                exit();
            }

            if(mainModel::verificar_datos("[a-zA-z0-9áéíóúÁÉÍÓÚñÑ ]{2,30}", $producto)){
                return '<div class="alert alert-warning" role="alert">
                <p class="text-center mb-0">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                El codigo no coincide con el formato solicitado
                </p>
                </div>';
                exit();
            }

            
            /*-------- Selecionando producto en la BD --------*/
            $datos_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE codigo_producto LIKE '$producto%' OR nombre_producto LIKE '$producto%' ORDER BY  codigo_producto DESC LIMIT 8 ");
            
            if($datos_producto->rowCount() >= 1  ){
                $datos_producto= $datos_producto->fetchAll();
                
                $tabla='
                <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm">
                <tbody>
                ';
                
                foreach( $datos_producto as $rows){
                    $tabla.='
                    <tr class="text-center">
                    <td>'.$rows['codigo_producto'].'  -  '.$rows['nombre_producto'].'</td>
                    <td>
                    <button type="button" class="btn btn-primary" onclick="modal_agregar_producto('.$rows['id_producto'].')" ><i class="fas fa-box-open"></i></button>
                    </td>
                    </tr>
                    ';
                }
                
                
                
                $tabla.='
                </tbody>
                </table>
                </div>
                ';
                return $tabla;
            }else{
                return '<div class="alert alert-warning" role="alert">
                <p class="text-center mb-0">
                <i class="fas fa-exclamation-triangle fa-2x"></i><br>
                No hemos encontrado ningún cliente en el sistema que coincida con <strong>“'.$producto.'”</strong>
                </p>
                </div>';
                exit();
            }
        }/* Fin de del controlador */

        /*-------- controlador agregar producto Pedido --------*/
        public function agregar_producto_pedido_controlador(){

            /*-------- recuperar el producto --------*/
            $id=mainModel::limpiar_cadena($_POST['id_agregar_producto']);

            /*-------- comprobando producto en la BD --------*/
            
            $check_producto=mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE id_producto='$id'");

            if($check_producto->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos encontrado el producto en el sistema ",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_producto->fetch();
            }
            
            /*-------- Detalles del producto para el pedido --------*/
            
            $cantidad=mainModel::limpiar_cadena($_POST['detalle_cantidad']);

            /*-------- comprobando campos vacios --------*/
            if($cantidad == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Por favor ingrese la cantidad del producto",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Verificando integridad de los datos --------*/
            if(mainModel::verificar_datos("[0-9]{1,7}",$cantidad)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La cantidad de producto no es invalido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }


            /*-------- Iniciando la sesion --------*/
            session_start(['name' => 'SDP']);
            
            if(empty($_SESSION['datos_producto'][$id])){
                
                $_SESSION['datos_producto'][$id]=[
                    "ID"=>$campos['id_producto'],
                    "COD"=>$campos['codigo_producto'],
                    "Nombre"=>$campos['nombre_producto'],
                    "Detalle" => $campos['descripcion_producto'],
                    "Cantidad" => $cantidad
                ];
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cliente Agregado",
                    "Texto"=>"El producto se agrego al pedido",
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El producto que intenta agregar ya se encuentra en el pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                
            }
            
            
        } /* fin del controlador */

        /*-------- Controlador eliminar producto Pedido --------*/
        public function eliminar_producto_pedido_controlador(){
            
            /*-------- recuperar el id producto --------*/
            $id=mainModel::limpiar_cadena($_POST['id_eliminar_producto']);

            //Inicando Sesion 
            session_start(['name' => 'SDP']);

            unset($_SESSION['datos_producto'][$id]);

            if(empty($_SESSION['datos_cliente'][$id])){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Producto removido",
                    "Texto"=>"El producto se a eliminado con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se ha podido eliminar",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);


        }/* Fin de del controlador */

        /*-------- Controlador datos Pedido --------*/
        public function datos_pedido_controlador($tipo, $id){
            $tipo=mainModel::limpiar_cadena($tipo);

            $id=mainModel::decryption($id);
            $id=mainModel::limpiar_cadena($id);

            return pedidoModelo::datos_pedido_modelo($tipo, $id);
        }/* Fin de del controlador */

        /*-------- Controlador agregar Pedido --------*/
        public function agregar_pedido_controlador(){
            $fecha_actual=date('Y-m-d');
            /*-------- Inicando Sesion --------*/
            session_start(['name' => 'SDP']);

            /*-------- Comprobando Producto --------*/
            if($_SESSION['total_producto']==0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No haz seleccionado ningun pedido para relaizar el pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando Cliente --------*/
            if(empty($_SESSION['datos_cliente'])){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No haz seleccionado ningun cliente para relaizar el pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Recibiendo datos del fomulario --------*/
            $fecha_emision=mainModel::limpiar_cadena($_POST['fecha_emision_pedido_reg']);
            $estado="Pendiente";

            /*-------- Comprobando la integridad de los datos --------*/
            if(mainModel::verificar_fechas($fecha_emision)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La fecha de emision no coincide con el formato solicitado",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- Comprobando fecha --------*/
            if(strtotime($fecha_emision) != strtotime($fecha_actual)){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"La fecha de emision no coincide con la fecha actual",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            /*-------- formatear total y fecha --------*/

            $fecha_emision=date("Y-m-d", strtotime($fecha_emision));

            /*-------- formatear total y fecha --------*/

            $correlativo=mainModel::ejecutar_consulta_simple("SELECT id_pedido FROM pedido");
            
            $correlativo=($correlativo->rowCount()) + 1;
            $codigo=mainModel::generar_codigo_aleatorio("CJ",7,$correlativo);

            /*-------- Agregar pedido --------*/
            $datos_pedido_reg=[
                "Codigo"=>$codigo,
                "Cantidad"=>$_SESSION['total_producto'],
                "Estado"=>$estado,
                "Fecha"=>$fecha_emision,
                "Cliente"=>$_SESSION['datos_cliente']['ID']
            ];

            $agregar_pedido=pedidoModelo::agregar_pedido_modelo($datos_pedido_reg);

            if($agregar_pedido->rowCount()!=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ERROR 001",
                    "Texto"=>"No se pudo agregar el pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*-------- Agregar detalle pedido --------*/
            $errores_detalles=0;

            foreach($_SESSION['datos_producto'] as $productos){

                $datos_detalle_reg=[
                    "COD" => $productos['COD'],
                    "Producto"=>$productos['Nombre'],
                    "Cantidad"=>$productos['Cantidad'],
                    "Codigo"=>$codigo
                ];

                $agregar_detalle_reg=pedidoModelo::agregar_detalle_pedido_modelo($datos_detalle_reg);
                
                if($agregar_detalle_reg->rowCount()!=1){
                    $errores_detalles=1;
                    break;
                }
            }

            if($errores_detalles==0){
                unset($_SESSION['datos_cliente']);
                unset($_SESSION['datos_producto']);
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Pedido registrado",
                    "Texto"=>"El pedido se registro de manera exitosa",
                    "Tipo"=>"success"
                ];
            }else{
                pedidoModelo::eliminar_pedido_modelo($codigo);
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ERROR 002",
                    "Texto"=>"No se pudo agregar el pedido",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        }/* Fin de del controlador */
        
        /*-------- Controlador paginar pedido --------*/
        public function paginador_pedido_controlador($pagina,$registros, $privilegio, $url,$tipo,$fecha_emision){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            $url=mainModel::limpiar_cadena($url);
            $url=SERVER_URL.$url."/";

            $tipo=mainModel::limpiar_cadena($tipo);

            $fecha_emision=mainModel::limpiar_cadena($fecha_emision);
            
            $tabla="";
            
            //Operador ternario que funciona como una condicional doble
            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;

            if($tipo=="Busquedad"){
                if(mainModel::verificar_fechas($fecha_emision)){
                    return '
                    <div class="alert alert-danger text-center" role="alert">
                        <p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
                        <h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
                        <p class="mb-0">Lo sentimos, no podemos realizar la busquedad ya que la fecha no es valida.</p>
                    </div>
                    ';
                    exit();
                }

            }

            $fecha_emision=date("Y-m-d", strtotime($fecha_emision));
            if($tipo=="Busquedad" && $fecha_emision!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM pedido WHERE fecha_pedido='$fecha_emision' LIMIT $inicio, $registros";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM pedido WHERE estado_pedido='$tipo' ORDER BY fecha_pedido DESC LIMIT $inicio, $registros";
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
                        <th>CODIGO DE PEDIDO</th>
                        <th>ESTADO DEL PEDIDO</th>
                        <th>FECHA</th>
                        <th>PDF</th>';
                        
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
                    <td>'.$rows['codigo_pedido'].'</td>
                    <td>'.$rows['estado_pedido'].'</td>

                    <td>'.date("d-m-Y", strtotime($rows['fecha_pedido'])).'</td>
                    <td>
                            <a href="'.SERVER_URL.'pedidos/pedido.php?id_cliente='.mainModel::encryption($rows['id_client']).'&cod='.mainModel::encryption($rows['codigo_pedido']).'" class=" btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                            </a>
                    </td>

                    ';

                    if($privilegio == 1 || $privilegio == 2){
                        if($rows['estado_pedido']=="Realizado"){
                            $tabla.='<td>
                            <button class="btn btn-success">
                            <i class="fas fa-edit"></i>
                            </button>
                        </td>';
                        }else{
                            $tabla.='<td>
                            <a href="'.SERVER_URL.'order-update/'.mainModel::encryption($rows['codigo_pedido']).'/" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                            </a>
                        </td>';
                        }
                
                    }
                    if($privilegio == 1 ){
                        $tabla.='<td>
                        <form class="FormularioAjax" action="'.SERVER_URL.'ajax/pedidoAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="codigo_pedido_del" value="'.mainModel::encryption($rows['codigo_pedido']).'">
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
                $tabla.='<p class=" text-right">Mostrando pedidos '. $reg_inicio.' al '.$reg_final.' de un total de '. $total .' </p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */

        /*-------- Controlador eliminar pedido --------*/
        public function eliminar_pedido_controlador(){
            
            /*--------Recuperando el codigo del pedido --------*/
            $codigo=mainModel::decryption($_POST['codigo_pedido_del']);
            $codigo=mainModel::limpiar_cadena($codigo);

            /*-------- comprobando el pedido en la BD --------*/

            $check_pedido=mainModel::ejecutar_consulta_simple("SELECT id_pedido FROM pedido WHERE codigo_pedido= '$codigo'");

            if($check_pedido->rowCount()!=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El pedido que intenta eliminar no existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            /*-------- Comprobando privilegios --------*/
            session_start(['name' => 'SDP']);
            if($_SESSION['privilegio_sdp'] != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No tienes los permisos necesarios para eliminar un pedido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $eliminar_pedido=pedidoModelo::eliminar_pedido_modelo($codigo);

            if($eliminar_pedido->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Pedido Eliminado",
                    "Texto"=>"El Pedido ha sido eliminado de manera exitosa",
                    "Tipo"=>"success"
                ];
                
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>">No se pudo eleminar el Pedido",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);




        }/* Fin de del controlador */

        /*-------- Controlador actualizar pedido --------*/
        public function actualizar_pedido_controlador(){
            /*-------- Recuperar codigo --------*/
            $codigo=mainModel::decryption($_POST['codigo_pedido_up']);
            $codigo=mainModel::limpiar_cadena($codigo);

            $estado=mainModel::limpiar_cadena($_POST['estado_pedido_up']);

            $check_pedido=mainModel::ejecutar_consulta_simple("SELECT * FROM pedido WHERE codigo_pedido= '$codigo'");

            if($check_pedido->rowCount()!=1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El pedido que intenta actualizar no existe en el sistema",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $campos=$check_pedido->fetch();
            }

            if($estado!=""){
                if($estado!=$campos['estado_pedido']){
                    if(mainModel::verificar_datos("[a-zA-Z]{1,9}",$estado)){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"ocurrio un error inesperado",
                            "Texto"=>"El Estado del pedido no coincide con el formato solicitado",
                            "Tipo"=>"error"
                        ];
                        echo json_encode($alerta);
                        exit();
                    }
                }else{
                    $estado=$campos['estado_pedido'];
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Por favor selecione un estado para el pedido ",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
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

            $datos_pedido_up=[
                "Codigo" => $codigo,
                "Estado" => $estado 
            ];

            $actualizar_pedido=pedidoModelo::actualizar_pedido_modelo($datos_pedido_up);
            if($actualizar_pedido->rowCount()==1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Pedido Actualizado",
                    "Texto"=>"El pedido ha sido actualizado con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"ocurrio un error inesperado",
                    "Texto"=>"Error en la actualizacion del pedido",
                    "Tipo"=>"error"
                ];
            }
            echo json_encode($alerta);
        }

        /*-------- Controlador paginar pedido --------*/
        public function paginador_pedido_individual_controlador($pagina,$registros, $privilegio, $url,$id){
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            $url=mainModel::limpiar_cadena($url);
            $url=SERVER_URL.$url."/".$id."/";
            
            $id=mainModel::decryption($id);
            $id=mainModel::limpiar_cadena($id);

            $check_cliente=mainModel::ejecutar_consulta_simple("SELECT id_cliente FROM cliente WHERE id_cliente='$id'");

            if($check_cliente->rowCount()<=0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos encontrado al cliente en el sistema ",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            
            $tabla="";
            
            //Operador ternario que funciona como una condicional doble
            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1 ;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0 ;


            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM pedido WHERE id_client='$id' ORDER BY fecha_pedido DESC LIMIT $inicio, $registros";


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
                        <th>CODIGO DE PEDIDO</th>
                        <th>ESTADO DEL PEDIDO</th>
                        <th>FECHA</th>
                        <th>PDF</th>';
                        
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
                    <td>'.$rows['codigo_pedido'].'</td>
                    <td>'.$rows['estado_pedido'].'</td>

                    <td>'.date("d-m-Y", strtotime($rows['fecha_pedido'])).'</td>
                    <td>
                            <a href="'.SERVER_URL.'pedidos/pedido.php?id_cliente='.mainModel::encryption($rows['id_client']).'&cod='.mainModel::encryption($rows['codigo_pedido']).'" class=" btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                            </a>
                    </td>

                    ';

                    if($privilegio == 1 || $privilegio == 2){
                        if($rows['estado_pedido']=="Realizado"){
                            $tabla.='<td>
                            <button class="btn btn-success">
                            <i class="fas fa-edit"></i>
                            </button>
                        </td>';
                        }else{
                            $tabla.='<td>
                            <a href="'.SERVER_URL.'order-update/'.mainModel::encryption($rows['codigo_pedido']).'/" class="btn btn-success">
                            <i class="fas fa-edit"></i>
                            </a>
                        </td>';
                        }
                
                    }
                    if($privilegio == 1 ){
                        $tabla.='<td>
                        <form class="FormularioAjax" action="'.SERVER_URL.'ajax/pedidoAjax.php" method="POST" data-form="delete" autocomplete="off">
                        <input type="hidden" name="codigo_pedido_del" value="'.mainModel::encryption($rows['codigo_pedido']).'">
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
                $tabla.='<p class=" text-right">Mostrando pedidos '. $reg_inicio.' al '.$reg_final.' de un total de '. $total .' </p>';
                $tabla.=mainModel::paginador_tablas($pagina, $Npaginas, $url, 7);
            }
            return $tabla;

        }/* Fin de del controlador */


    }
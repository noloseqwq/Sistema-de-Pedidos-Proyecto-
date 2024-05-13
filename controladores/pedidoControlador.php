<?php

    if($peticionAjax){
        require_once "../modelos/pedidoModelo.php"; 
    }else{
        require_once "./modelos/pedidoModelo.php";
    }

    class pedidoControlador extends pedidoModelo {

        /*-------- controlador buscar Cliente --------*/
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
        
        /*-------- controlador agregar Cliente --------*/
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
    }
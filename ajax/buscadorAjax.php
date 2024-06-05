<?php
session_start(['name' => 'SDP']);
require_once "../config/APP.php";

if(isset($_POST['busqueda_inicial']) || isset($_POST['eliminar_busqueda']) || isset($_POST['fecha_creacion']) ){

    $data_URL=[
        "usuario"=> "user-search",
        "cliente"=> "client-search",
        "producto"=>"product-search",
        "pedido"=>"order-search"
    ];

    if(isset($_POST['modulo'])){
        $modulo=$_POST['modulo'];
        if(!isset($data_URL[$modulo])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No podemos continuar con la busquedad debido a un error",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }else{
        $alerta=[
            "Alerta"=>"simple",
            "Titulo"=>"Ocurrio un error inesperado",
            "Texto"=>"No podemos continuar con la busquedad",
            "Tipo"=>"error"
        ];
        echo json_encode($alerta);
        exit();
    }

    if($modulo=="pedido"){
        $fecha_creacion="fecha_creacion_".$modulo;
        /* iniciar busquedad*/
        if(isset($_POST['fecha_creacion']) ){

            if($_POST['fecha_creacion']==""){       
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"llene los campos requeridos",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $_SESSION[$fecha_creacion]= date("d-m-Y", strtotime($_POST['fecha_creacion']));
        }

        /*Eliminar busqueda*/        
        if(isset($_POST['eliminar_busqueda'])){
            unset($_SESSION[$fecha_creacion]);
        }

    }else{
        $name_var= "busquedad_".$modulo;
        /* iniciar busquedad*/
        if(isset($_POST['busqueda_inicial'])){
            if($_POST['busqueda_inicial']==""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"llene los campos requeridos",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $_SESSION[$name_var]=$_POST['busqueda_inicial'];
        }
        /*Eliminar busqueda*/        
        if(isset($_POST['eliminar_busqueda'])){
            unset($_SESSION[$name_var]);
        }
    }

    //redireccionar
    $URL=$data_URL[$modulo];
    $alerta=[
        "Alerta"=>"redireccionar",
        "URL"=>SERVER_URL.$URL."/"
    ];
    echo json_encode($alerta);


}else{
    session_unset();
    session_destroy();
    header("Location: ".SERVER_URL."login/");
}

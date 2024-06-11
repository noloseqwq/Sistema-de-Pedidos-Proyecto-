<?php

ob_start();
require_once "../config/APP.php";
$peticionAjax=true;
require_once "../controladores/clienteControlador.php";

$ins_cliente = new clienteControlador;
$datos_cliente = $ins_cliente->datos_cliente_controlador("Unico", $_GET['id_cliente']);
$campos_cliente=$datos_cliente->fetch();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Pedido || <?php echo COMPANY ?></title>
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/css/style.css">

</head>

<body>


    <div class="cabecera">

        <div class="logo-E">
            <img class="logo" src="<?php echo SERVER_URL ?>vistas/assets/img/logoD.jpg" alt="">
        </div>

        <div class="datos-cliente">
            <h5>RIF: <?php echo $campos_cliente['cliente_rif']?></h5>
            <h5>Razón social:  <?php echo $campos_cliente['cliente_razon']?></h5>
        </div>


    </div>

    <div class="contenido">
        <?php 
        require_once "../controladores/pedidoControlador.php";
        $ins_pedido= new pedidoControlador;
        $datos_pedido = $ins_pedido->datos_pedido_controlador("Unico", $_GET['cod']);

        $campos_pedido= $datos_pedido->fetch();

        ?>
        <h5 style="font: 1.2em sans-serif; margin-top: 20% ;">Fecha de emision del Pedido: <?php echo date("d-m-Y", strtotime($campos_pedido['fecha_pedido']))?></h5>
        <div class="table-responsive">
            <table  class="table  table-dark table-sm tabla-pdf">
                <thead>
                    <tr class="text-center ">
                        <th>CODIGO</th>
                        <th>NOMBRE DEL PRODUCTO</th>
                        <th>CANTIDAD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 

                    $datos_detalle = $ins_pedido->datos_pedido_controlador("Detalle", $_GET['cod']);
                    $campos_detalle= $datos_detalle-> fetchAll();

                    foreach($campos_detalle as $rows){

                    
                    ?>
                    <tr class="text-center">
                        <td class="td_pdf"><?php echo $rows['cod_proc']?></td>
                        <td class="td_pdf"><?php echo $rows['producto_nombre']?></td>
                        <td class="td_pdf"><?php echo $rows['cantidad_detalle']?></td>

                        
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>




</body>






<?php

$html = ob_get_clean();

require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->load_html($html);


$dompdf->render();

$dompdf->stream($campos_cliente['cliente_razon'].".pdf", array("Attachment" => false));



?>
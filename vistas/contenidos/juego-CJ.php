<?php

$texto='$CONDOMINIO@2024';
$texto2='310124';
$clave="43424324";
$aceitunas= hash('sha256',$texto ) ;

echo "----->Llave con hash<-----";

echo "<br>";

echo $aceitunas;

echo "<br>";
echo "----->Llave 2 con hash y seleccion espesifica de caracteres<-----";

echo "<br>";

$texto2CORTA= substr(hash('sha256',$texto2 ), 0, 16);

echo $texto2CORTA;
echo "<br>";

echo "----->Clave que se va a encriptar<-----";

echo "<br>";

echo $clave;

echo "<br>";

$textoEncypt= openssl_encrypt($clave,"AES-256-CBC",$aceitunas,0 ,$texto2CORTA );
echo "----->Clave encriptada con las llaves<-----";

echo "<br>";

echo $textoEncypt;
echo "<br>";

$texto64= base64_encode($textoEncypt) ;

echo $texto64;
echo "<br>";


$textoNO64= base64_decode($texto64) ;
echo $textoNO64;


$claveDes= openssl_decrypt($textoNO64,"AES-256-CBC", $aceitunas, 0, $texto2CORTA) ;

echo "<br>";

echo $claveDes;











?>
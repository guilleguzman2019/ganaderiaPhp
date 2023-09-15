<?php
require_once 'config.php';
 
try {
    $adapter->authenticate();
    $token = $adapter->getAccessToken();

    $archivoToken = 'token.txt';

    // Abre el archivo en modo escritura
    $file = fopen($archivoToken, 'w');

    // Escribe el token en el archivo
    if ($file) {
        fwrite($file, json_encode($token));
        fclose($file);
        header('Location: listado.php');
        exit();
    } else {
        echo "Error al abrir el archivo para escritura.";
    }
}
catch( Exception $e ){
    echo $e->getMessage() ;
}
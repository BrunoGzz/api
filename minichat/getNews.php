<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

require 'database.php';

$jsonData = file_get_contents("php://input");

try {
    $ruta_archivo = './news.html';

    // Lee el contenido del archivo HTML
    $contenido_html = file_get_contents($ruta_archivo);

    // Imprime el contenido HTML
    echo $contenido_html;
} catch (Exception $e) {
    echo "";
}
?>
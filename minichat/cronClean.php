<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

require 'database.php';

try {
    $sql = "SELECT CONCAT('KILL ',id,';') FROM information_schema.processlist;";
    $statement = $conn->prepare($sql);

    if ($statement->execute()) {
        $message = ['success' => true];
        echo json_encode($message); 
    }else {
        $message = ['success' => false, 'error' => 'Error al borrar mensajes', 'data' => $data];
        echo json_encode($message);
    }
} catch (Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
}
?>
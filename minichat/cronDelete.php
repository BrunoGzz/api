<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

require 'database.php';

try {
    $fechaLimite = date('Y-m-d H:i:s', strtotime('-7 days'));
    $mensajePermitido = "Hello! Let's talk! 👋";

    // Cláusula real. Activar al subir cron y actualización
    $sqlDeleteMessages = "DELETE FROM messages WHERE `timestamp` < :fechaLimite AND `text` <> :mensajePermitido";
    $stmtDeleteMessages = $conn->prepare($sqlDeleteMessages);
    $stmtDeleteMessages->bindParam(':fechaLimite', $fechaLimite);
    $stmtDeleteMessages->bindParam(':mensajePermitido', $mensajePermitido);
    
    if ($stmtDeleteMessages->execute()) {
        $message = ['success' => true, 'timestamp' => date('Y-m-d H:i:s')];
        echo json_encode($message); 
    } else {
        $message = ['success' => false, 'error' => 'Error al borrar mensajes', 'data' => $data];
        echo json_encode($message);
    }
} catch (Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
}
?>
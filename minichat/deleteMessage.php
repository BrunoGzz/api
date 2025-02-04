<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

require 'database.php';

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);
try {
    if (!empty($data->id) && !empty($data->messageId)) {
        $query = "SELECT username FROM users WHERE userId = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $data->id);
        $stmt->execute();
        
        $senderUsername = $stmt->fetchColumn();
        
        if (!$senderUsername) {
            $message = ['success' => false, 'error' => 'El remitente no fue encontrado'];
            echo json_encode($message);
            exit; // Salir del script si el remitente no existe
        }
        
        $insert_sql = "DELETE FROM `messages` WHERE `sender` = :username AND `id` = :id";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':username', $senderUsername);
        $insert_stmt->bindParam(':id', $data->messageId);

        if ($insert_stmt->execute()) {
            $message = ['success' => true];
            echo json_encode($message);
        } else {
            $message = ['success' => false, 'error' => 'Error al insertar en la base de datos'];
            echo json_encode($message);
        }
    } else {
        $message = ['success' => false, 'error' => 'Rellena todos los datos'];
        echo json_encode($message);
    }
} catch (Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
}
?>
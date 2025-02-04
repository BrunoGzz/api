<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST");

require 'database.php';

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);

try {
    if (!empty($data->id) && !empty($data->time)) {
        // Obtener el nombre de usuario del remitente
        $query = "SELECT username FROM users WHERE userId = :sender";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sender', $data->id);
        $stmt->execute();
        
        $senderUsername = $stmt->fetchColumn();
        
        if (!$senderUsername) {
            $message = ['success' => false, 'error' => 'El remitente no fue encontrado'];
            echo json_encode($message);
            exit; // Salir del script si el remitente no existe
        }
        
        $actual_date = date("Y-m-d H:i:s");
        
        $insert_sql = "SELECT COUNT(*) as newMessages FROM messages WHERE receiver = :receiver AND STR_TO_DATE(timestamp, '%Y-%m-%d %H:%i:%s') > STR_TO_DATE(:time, '%Y-%m-%d %H:%i:%s')";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':receiver', $senderUsername);
        $insert_stmt->bindParam(':time', $data->time);
        $insert_stmt->execute();

        $result = $insert_stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($result) {
            $message = ['success' => true, 'newMessages' => $result["newMessages"]];
            echo json_encode($message);
        } else {
            $message = ['success' => true, 'newMessages' => 0];
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
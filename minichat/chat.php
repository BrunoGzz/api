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
// ...

try {
    if (!empty($data->user1) && !empty($data->user2)) {
        // Obtener el nombre de usuario de user1
        $queryUser1 = "SELECT username FROM users WHERE userId = :user1";
        $stmtUser1 = $conn->prepare($queryUser1);
        $stmtUser1->bindParam(':user1', $data->user1);
        $stmtUser1->execute();
        
        $user1Username = $stmtUser1->fetchColumn();
        
        if (!$user1Username) {
            $message = ['success' => false, 'error' => 'El usuario 1 no fue encontrado'];
            echo json_encode($message);
            exit; // Salir del script si el usuario 1 no existe
        }
        
        $sql = "SELECT * FROM messages 
        WHERE sender = :user1 AND receiver = :user2
        UNION ALL
        SELECT * FROM messages 
        WHERE sender = :user2 AND receiver = :user1
        ORDER BY timestamp ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user1', strtolower($user1Username)); // Usar el nombre de usuario como user1
        $stmt->bindParam(':user2', strtolower($data->user2));

        if ($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $message = ['success' => true, 'data' => $results];
            echo json_encode($message);
        }
    } else {
        $message = ['success' => false, 'error' => 'Rellena todos los datos', 'data' => $data];
        echo json_encode($message);
    }
} catch (Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
}

?>
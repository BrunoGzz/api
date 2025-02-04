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
    if (!empty($data->id)) {
        // Obtener el nombre de usuario de user1
        $queryUser = "SELECT username FROM users WHERE userId = :id";
        $stmtUser = $conn->prepare($queryUser);
        $stmtUser->bindParam(':id', $data->id);
        $stmtUser->execute();
        
        $username = $stmtUser->fetchColumn();
        
        if (!$username) {
            $message = ['success' => false, 'error' => 'No se encontro ningún usuario con ese ID'];
            echo json_encode($message);
            exit; // Salir del script si el usuario 1 no existe
        }
        
        $sql = "SELECT id, extension FROM stickers 
        WHERE creator = :username ORDER BY timestamp ASC";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', strtolower($username)); // Usar el nombre de usuario como user1

        if ($stmt->execute()) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $message = ['success' => true, 'data' => $results];
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
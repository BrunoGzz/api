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
    if (!empty($data->username)) {
        // Obtener el nombre de usuario correspondiente a userId
        $sqlGetUsername = "SELECT username FROM users WHERE userId = :userId";
        $stmtGetUsername = $conn->prepare($sqlGetUsername);
        $stmtGetUsername->bindParam(':userId', $data->username);
        
        if ($stmtGetUsername->execute()) {
            $resultGetUsername = $stmtGetUsername->fetch(PDO::FETCH_ASSOC);
            $username = $resultGetUsername['username'];
            
            // Consulta principal con el nombre de usuario obtenido
            $sql = "SELECT COUNT(*) AS requests
            FROM requests
            WHERE receiver = :username AND accepted IS NULL";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', strtolower($username));

            if ($stmt->execute()) {
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $message = ['success' => true, 'data' => $results["requests"]];

                echo json_encode($message);
            }
        } else {
            $message = ['success' => false, 'error' => 'Error al obtener el nombre de usuario', 'data' => $data];
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
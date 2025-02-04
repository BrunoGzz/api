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
            $sql = "SELECT sender, receiver
            FROM requests
            WHERE receiver = :username AND accepted IS NULL
            ORDER BY timestamp DESC;";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', strtolower($username));

            if ($stmt->execute()) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $message = ['success' => true, 'data' => $results];

                for ($i = 0; $i < count($message['data']); $i++) {
                    $sql2 = "SELECT color, username FROM users WHERE username = :resultUsername";
                    $stmt2 = $conn->prepare($sql2);
                    
                    if ($message['data'][$i]["sender"] == strtolower($username)) {
                        $stmt2->bindParam(':resultUsername', strtolower($message['data'][$i]["receiver"]));
                    } else {
                        $stmt2->bindParam(':resultUsername', strtolower($message['data'][$i]["sender"]));
                    }

                    if ($stmt2->execute()) {
                        $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        array_push($message['data'][$i], $results2);
                    }
                }
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
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

            $sqlLastActivity = "UPDATE users SET `lastActivity` = :lastActivity WHERE userId = :userId";
            $stmtLastActivity = $conn->prepare($sqlLastActivity);
            $stmtLastActivity->bindParam(':userId', $data->username);
            $stmtLastActivity->bindParam(':lastActivity', date("Y-m-d H:i:s"));
            $stmtLastActivity->execute();
            
            // Consulta principal con el nombre de usuario obtenido
            $sql = "SELECT members.groupId 
            FROM members 
            INNER JOIN groups ON members.groupId = groups.id
            WHERE members.userId = :id 
            ORDER BY groups.timestamp DESC";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', strtolower($username));

            if ($stmt->execute()) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $resultsArray = [];

                for ($i = 0; $i < count($results); $i++) {
                    $sql2 = "SELECT color, username, id FROM groups WHERE id = :groupId";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bindParam(':groupId', $results[$i]["groupId"]);

                    if ($stmt2->execute()) {
                        $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        $sql2 = "SELECT text, sender FROM messages WHERE receiver = :groupId ORDER BY id DESC";
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bindParam(':groupId', $results[$i]["groupId"]);
                        $stmt2->execute();
                        array_push($results2, $stmt2->fetchAll(PDO::FETCH_ASSOC));
                        $resultsArray[$i] = $results2;
                    }
                }
                $message = ['success' => true, 'data' => $resultsArray];
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
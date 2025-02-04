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
    if (!empty($data->username) && isset($data->status) && !empty($data->id)) {
        $sqlGetUsername = "SELECT username FROM users WHERE userId = :userId";
        $stmtGetUsername = $conn->prepare($sqlGetUsername);
        $stmtGetUsername->bindParam(':userId', $data->id);
        
        if ($stmtGetUsername->execute()) {
            $resultGetUsername = $stmtGetUsername->fetch(PDO::FETCH_ASSOC);
            $username = $resultGetUsername['username'];
            $query = "SELECT sender FROM requests WHERE sender = :username";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', strtolower($data->username));
            $stmt->execute();
            
            $senderUsername = $stmt->fetchColumn();
            
            if (!$senderUsername) {
                $message = ['success' => false, 'error' => 'El remitente no fue encontrado'];
                echo json_encode($message);
                exit; // Salir del script si el remitente no existe
            }

            try {
                $insert_sql = "UPDATE `requests` SET `accepted`=:statusAccept WHERE `sender` = :username AND `receiver` = :id";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bindParam(':username', $senderUsername);
                $insert_stmt->bindParam(':statusAccept', $data->status);
                $insert_stmt->bindParam(':id', $username); 
            
                if ($insert_stmt->execute() && intval($data->status) == 1) {
                    $check_receiver = strtolower($data->username);
                    $actual_date = date("Y-m-d H:i:s");
                    $encoded_text = "Hello! Let's talk! 👋";
                    
                    $insert_sql = "INSERT INTO `messages` (`sender`, `receiver`, `text`, `timestamp`) VALUES (:sender, :receiver, :messageText, :timestamp)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bindParam(':receiver', $senderUsername);
                    $insert_stmt->bindParam(':sender', $username);
                    $insert_stmt->bindParam(':messageText', $encoded_text);
                    $insert_stmt->bindParam(':timestamp', $actual_date);
            
                    if ($insert_stmt->execute()) {
                        $message = ['success' => true];
                        echo json_encode($message);
                    } else {
                        throw new Exception('Error al insertar en la tabla "messages".');
                    }
                } else {
                    $message = ['success' => true];
                    echo json_encode($message);
                }
            } catch (Exception $e) {
                $message = ['success' => false, 'error' => $e->getMessage()];
                echo json_encode($message);
            }            
        }else{
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
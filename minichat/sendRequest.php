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
    if (!empty($data->sender) && !empty($data->receiver)) {

        // Obtener el nombre de usuario del remitente
        $query = "SELECT username FROM users WHERE userId = :sender";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sender', $data->sender);
        $stmt->execute();
        
        $senderUsername = $stmt->fetchColumn();
        
        if(strtolower($senderUsername) == strtolower($data->receiver)){
            $message = ['success' => false, 'status' => 5, 'error' => 'El remitente no fue encontrado'];
            echo json_encode($message);
            exit;
        }

        if (!$senderUsername) {
            $message = ['success' => false, 'error' => 'El remitente no fue encontrado'];
            echo json_encode($message);
            exit; // Salir del script si el remitente no existe
        }
        
        $check_receiver = strtolower($data->receiver);
        $actual_date = date("Y-m-d H:i:s");

        // Verificar si ya existe una entrada con el mismo sender y receiver (o al revés)
        $check_sql = "SELECT COUNT(*) as count FROM `requests` WHERE 
        (`sender` = :sender AND `receiver` = :receiver) OR
        (`sender` = :receiver AND `receiver` = :sender)";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':sender', $senderUsername);
        $check_stmt->bindParam(':receiver', $check_receiver);
        $check_stmt->execute();
        $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            $check_sql = "SELECT COUNT(*) as count FROM `requests` WHERE 
            ((`sender` = :sender AND `receiver` = :receiver) OR
            (`sender` = :receiver AND `receiver` = :sender)) AND (`accepted` IS NULL)";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bindParam(':sender', $senderUsername);
            $check_stmt->bindParam(':receiver', $check_receiver);
            $check_stmt->execute();
            $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                $message = ['success' => false, 'status' => 1];
                echo json_encode($message);
                exit;
            }else{
                $check_sql = "SELECT COUNT(*) as count FROM `requests` WHERE 
                ((`sender` = :sender AND `receiver` = :receiver) OR
                (`sender` = :receiver AND `receiver` = :sender)) AND (`accepted` = 0)";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bindParam(':sender', $senderUsername);
                $check_stmt->bindParam(':receiver', $check_receiver);
                $check_stmt->execute();
                $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0){
                    // Ya existe una entrada con el mismo sender y receiver (o al revés)
                    $update_sql = "UPDATE `requests` SET `accepted` = NULL WHERE 
                    (`sender` = :sender AND `receiver` = :receiver AND `accepted` = 0)";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bindParam(':sender', $senderUsername);
                    $update_stmt->bindParam(':receiver', $check_receiver);

                    if ($update_stmt->execute()) {
                        $message = ['success' => false, 'status' => 2];
                        echo json_encode($message);
                    } else {
                        $message = ['success' => false, 'error' => 'Error al actualizar el valor en la base de datos'];
                        echo json_encode($message);
                    }
                }else{
                    $encoded_text = "Hello! Let's talk! 👋";
                    
                    $insert_sql = "INSERT INTO `messages` (`sender`, `receiver`, `text`, `timestamp`) VALUES (:sender, :receiver, :messageText, :timestamp)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bindParam(':receiver', $check_receiver);
                    $insert_stmt->bindParam(':sender', $senderUsername);
                    $insert_stmt->bindParam(':messageText', $encoded_text);
                    $insert_stmt->bindParam(':timestamp', $actual_date);
            
                    if ($insert_stmt->execute()) {
                        $message = ['success' => false, 'status' => 0];
                        echo json_encode($message);
                    } else {
                        throw new Exception('Error al insertar en la tabla "messages".');
                    }
                }
            }
        } else {
            // No existe una entrada, realizar la inserción
            $insert_sql = "INSERT INTO `requests` (`sender`, `receiver`, `timestamp`) VALUES (:sender, :receiver, :timestamp)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bindParam(':receiver', $check_receiver);
            $insert_stmt->bindParam(':sender', $senderUsername);
            $insert_stmt->bindParam(':timestamp', $actual_date);
        
            if ($insert_stmt->execute()) {
                $message = ['success' => true];
                echo json_encode($message);
            } else {
                $message = ['success' => false, 'error' => 'Error al insertar en la base de datos'];
                echo json_encode($message);
            }
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
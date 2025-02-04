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
    if (!empty($data->id) && !empty($data->member) && !empty($data->groupId)) {
        $sqlGetUsername = "SELECT username FROM users WHERE userId = :userId";
        $stmtGetUsername = $conn->prepare($sqlGetUsername);
        $stmtGetUsername->bindParam(':userId', $data->id);
        
        if ($stmtGetUsername->execute()) {
            $resultGetUsername = $stmtGetUsername->fetch(PDO::FETCH_ASSOC);
            $username = $resultGetUsername['username'];

            $query = "SELECT id, creatorId FROM groups WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $data->groupId);
            $stmt->execute();
            
            $creatorData = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($creatorData["creatorId"] != $username) {
                $message = 99;
                echo json_encode($message);
                exit; // Salir del script si el remitente no existe
            }else{
                $query = "SELECT COUNT(*) FROM requests WHERE (sender = :username OR receiver = :username) AND (sender = :member OR receiver = :member) AND accepted = 1";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':member', $data->member);
                $stmt->execute();

                $friendRequest = $stmt->fetchColumn();

                if ($friendRequest > 0) {
                    $insert_sql = "INSERT INTO `members` (`groupId`, `userId`, `role`) VALUES (:groupId, :userId, 'admin')";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bindParam(':userId',$data->member);
                    $insert_stmt->bindParam(':groupId', $data->groupId);

                    if ($insert_stmt->execute()) {
                        echo 1;
                    } else {
                        $message = ['success' => false, 'error' => 'Error al insertar en la base de datos'];
                        echo json_encode($message);
                    }   
                } else {
                    // No existe ninguna solicitud de amistad con los criterios especificados
                    echo 2;
                }
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
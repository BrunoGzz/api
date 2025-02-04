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

if (!empty($data->id)) {
    $check_sql = "SELECT `username`, `color`, `lastActivity` FROM `users` WHERE `username` = :id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':id', $data->id);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        if(!empty($data->whoIsThis)){
            // Obtener el nombre de usuario de user1
            $queryUser1 = "SELECT username FROM users WHERE userId = :user1";
            $stmtUser1 = $conn->prepare($queryUser1);
            $stmtUser1->bindParam(':user1', $data->whoIsThis);
            $stmtUser1->execute();
            
            $user1Username = $stmtUser1->fetchColumn();

            if (!$user1Username) {
                $message = ['success' => false, 'error' => 'El usuario 1 no fue encontrado'];
                echo json_encode($message);
                exit; // Salir del script si el usuario 1 no existe
            }else{
                $sqlLastActivity = "UPDATE users SET `lastActivity` = :lastActivity WHERE userId = :userId";
                $stmtLastActivity = $conn->prepare($sqlLastActivity);
                $stmtLastActivity->bindParam(':userId', $data->whoIsThis);
                $stmtLastActivity->bindParam(':lastActivity', date("Y-m-d H:i:s"));
                $stmtLastActivity->execute();
            }
        }

        array_push($result, ["active" => strtotime(date("Y-m-d H:i:s")) - strtotime($result["lastActivity"]) <= 10]);
        $message = ['success' => true, 'data' => json_encode($result)];
        echo json_encode($message);
    } else {
        $message = ['success' => false];
        echo json_encode($message);
    }
} else {
    $message = ['success' => false, 'error' => 'Rellena todos los datos'];
    echo json_encode($message);
}
?>
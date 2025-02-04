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
    $check_sql = "SELECT COUNT(*) AS count FROM `users` WHERE `username` = :id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':id', $data->id);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        $message = ['success' => true];
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
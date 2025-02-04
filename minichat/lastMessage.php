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
if (!empty($data->user1) && !empty($data->user2)) {
    $sql = "SELECT *
    FROM messages
    WHERE (sender = :user1 AND receiver = :user2) OR (sender = :user2 AND receiver = :user1)
    ORDER BY timestamp DESC
    LIMIT 1;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user1', strtolower($data->user1));
    $stmt->bindParam(':user2', strtolower($data->user2));

    if ($stmt->execute()) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $message = ['success' => true, 'data' => $results];
        echo json_encode($message);
    }
} else {
    $message = ['success' => false, 'error' => 'Rellena todos los datos', 'data' => $data];
    echo json_encode($message);
}}catch(Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
  }
?>
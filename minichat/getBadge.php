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
    $sql = "SELECT badgeHtml FROM badgeInfo WHERE badgeNum = :badgeId";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':badgeId', $data->badgeId);

    if ($stmt->execute()) {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $message = ['success' => true, 'data' => $results["badgeHtml"]];
        echo json_encode($message);
    }
}catch(Exception $e) {
    $message = ['success' => false, 'error' => $e->getMessage()];
    echo json_encode($message);
  }
?>
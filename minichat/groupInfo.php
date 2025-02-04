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
    // Obtener información del grupo
    $group_sql = "SELECT `username`, `color`, `creatorId` FROM `groups` WHERE `id` = :id";
    $group_stmt = $conn->prepare($group_sql);
    $group_stmt->bindParam(':id', $data->id);
    $group_stmt->execute();
    $group_result = $group_stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener IDs de los miembros del grupo
    $members_sql = "SELECT userId FROM `members` WHERE `groupId` = :groupId";
    $members_stmt = $conn->prepare($members_sql);
    $members_stmt->bindParam(':groupId', $data->id);
    $members_stmt->execute();
    $member_ids = $members_stmt->fetchAll(PDO::FETCH_COLUMN);

    if ($group_result) {
        $message = ['success' => true, 'group_data' => $group_result, 'members' => $member_ids];
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
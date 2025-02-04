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

if (!empty($data->username) && !empty($data->id) && !empty($data->color)) {
    // Verifica la longitud del nombre de usuario
    if (strlen($data->username) > 50) {
        $message = ['success' => false, 'error' => 'Longitud del nombre de usuario debe ser de máximo 50 caracteres'];
        echo json_encode($message);
        exit;
    }

    $check_username = strtolower($data->username);
    $check_sql = "SELECT COUNT(*) AS count FROM `users` WHERE `username` = :username";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':username', $check_username);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // El usuario ya existe, devuelve un mensaje de error
        $message = ['success' => false, 'error' => 1];
        echo json_encode($message);
    } else {
        // El usuario no existe, realiza la inserción en la base de datos
        $insert_sql = "INSERT INTO `users` (`userId`, `username`, `color`) VALUES (:id, :username, :color)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':username', $check_username);
        $insert_stmt->bindParam(':id', $data->id);
        $insert_stmt->bindParam(':color', $data->color);

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
?>

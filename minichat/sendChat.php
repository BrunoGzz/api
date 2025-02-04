<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

require __DIR__ . '/vendor/autoload.php';

require 'database.php';

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData);
try {
    if (!empty($data->sender) && !empty($data->receiver) && !empty($data->messageText)) {
        // Obtener el nombre de usuario del remitente
        $query = "SELECT username FROM users WHERE userId = :sender";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sender', $data->sender);
        $stmt->execute();
        
        $senderUsername = $stmt->fetchColumn();
        
        if (!$senderUsername) {
            $message = ['success' => false, 'error' => 'El remitente no fue encontrado'];
            echo json_encode($message);
            exit; // Salir del script si el remitente no existe
        }
        
        $check_receiver = strtolower($data->receiver);
        $actual_date = date("Y-m-d H:i:s");
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($data->messageText);
        $encoded_text = $clean_html;
        
        $insert_sql = "INSERT INTO `messages` (`sender`, `receiver`, `text`, `timestamp`) VALUES (:sender, :receiver, :messageText, :timestamp)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bindParam(':receiver', $check_receiver);
        $insert_stmt->bindParam(':sender', $senderUsername); // Usar el nombre de usuario como sender
        $insert_stmt->bindParam(':messageText', $encoded_text);
        $insert_stmt->bindParam(':timestamp', $actual_date);

        if ($insert_stmt->execute()) {
            $message = ['success' => true, 'extra' => $clean_html];
            echo json_encode($message);
        } else {
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
<!--?php
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

if (!empty($data->id) && !empty($data->color)) {
    // Verificar si el usuario existe en la tabla 'users'
    $check_sql = "SELECT * FROM `users` WHERE `userId` = :id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':id', $data->id);
    $check_stmt->execute();
    $result = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        // Verificar si el usuario existe en la tabla 'winners'
        $check_sql = "SELECT * FROM `prizes` WHERE `username` = :id";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bindParam(':id',$result["username"]);
        $check_stmt->execute();
        
        $winner_result = $check_stmt->fetch(PDO::FETCH_ASSOC);

        if ($winner_result !== false) {
            if (count($winner_result) > 0) {
                // El usuario existe en 'prizes', actualizar colorHex
                $update_sql = "UPDATE `prizes` SET colorHex = :color WHERE `username` = :id";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':id', $result["username"]);
                $update_stmt->bindParam(':color', $data->color);
                if ($update_stmt->execute()) {
                    $message = ['success' => true];
                    echo json_encode($message);
                } else {
                    $message = ['success' => false, 'error' => 'Error al actualizar en la base de datos'];
                    echo json_encode($message);
                }
            } else {
                // El usuario no existe en 'prizes'
                $message = ['success' => false, 'error' => 'El usuario no existe en la tabla de premios'];
                echo json_encode($message);
            }
        } else {
            // El usuario no existe en 'prizes'
            $message = ['success' => false, 'error' => 'El usuario no existe en la tabla de premios'];
            echo json_encode($message);
        }
    } else {
        // El usuario no existe en 'users'
        $message = ['success' => false, 'error' => 'El usuario no existe en la tabla de usuarios'];
        echo json_encode($message);
    }
} else {
    $message = ['success' => false, 'error' => 'Rellena todos los datos'];
    echo json_encode($message);
}
?>
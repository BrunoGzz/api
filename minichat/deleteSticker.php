<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST");

require 'database.php';

if (!empty($_POST["id"])) {
    $stickerId = $_POST["id"];

    // Verificar si el sticker existe en la base de datos
    $check_sql = "SELECT id, extension FROM `stickers` WHERE `id` = :id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':id', $stickerId);
    $check_stmt->execute();
    $sticker = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($sticker) {
        // El sticker existe, proceder a eliminarlo de la base de datos y del servidor
        $delete_sql = "DELETE FROM `stickers` WHERE `id` = :id";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bindParam(':id', $stickerId);

        if ($delete_stmt->execute()) {
            // Eliminar el archivo del servidor
            $filePath = "stickers/" . $stickerId . "." . $sticker['extension'];
            if (file_exists($filePath)) {
                unlink($filePath); // Elimina el archivo del servidor
            }

            // Respuesta de éxito
            echo json_encode(["status" => 1, "message" => "Sticker eliminado con éxito"]);
        } else {
            // Error al eliminar en la base de datos
            echo json_encode(["status" => 0, "message" => "Error al eliminar el sticker en la base de datos"]);
        }
    } else {
        // El sticker no existe
        echo json_encode(["status" => 0, "message" => "Sticker no encontrado"]);
    }
} else {
    // Si no se envió un ID válido
    echo json_encode(["status" => 0, "message" => "ID de sticker no proporcionado"]);
}
?>

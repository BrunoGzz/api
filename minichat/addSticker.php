<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");
header("Allow: POST");

require 'database.php';

// Function to generate a random string (32 characters in length)
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length / 2)); // Generates a random string of the desired length
}

$check_username = "";

if (!empty($_POST["id"])) {
    $check_sql = "SELECT username FROM `users` WHERE `userId` = :id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindParam(':id', $_POST["id"]);
    $check_stmt->execute();
    $result = $check_stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $check_username = $result[0]["username"];
    } else {
        echo json_encode(["status" => 0]);
        exit();
    }
} else {
    echo json_encode(["status" => 0]);
    exit();
}

if ($_FILES["photo"]["error"] > 0) {
    echo json_encode(["status" => 0]);
} else {
    if (isset($_FILES["photo"]) &&  $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        $allowed = array("image/png", "image/jpg", "image/jpeg", "image/gif");
        $limit_kb = 1024;
        if (in_array($_FILES["photo"]["type"], $allowed) && $_FILES["photo"]["size"] <= $limit_kb * 1024) {
            $directory = "stickers/";
            // Generate a random string for the file name
            $randomString = generateRandomString(32);
            $newFileName = $directory . $randomString . ".png"; // Ensure PNG extension for all files
            // Check if the file was uploaded
            if (is_uploaded_file($_FILES["photo"]["tmp_name"])) {
                // Load the image based on its MIME type
                $imageType = $_FILES["photo"]["type"];
                switch ($imageType) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        $sourceImage = imagecreatefromjpeg($_FILES["photo"]["tmp_name"]);
                        break;
                    case 'image/png':
                        $sourceImage = imagecreatefrompng($_FILES["photo"]["tmp_name"]);
                        break;
                    case 'image/gif':
                        $sourceImage = imagecreatefromgif($_FILES["photo"]["tmp_name"]);
                        break;
                    default:
                        echo json_encode(["status" => 0]);
                        exit();
                }

                if ($sourceImage) {
                    // Get original dimensions
                    $originalWidth = imagesx($sourceImage);
                    $originalHeight = imagesy($sourceImage);

                    // Create a new true color image with 50x50 dimensions
                    $newImage = imagecreatetruecolor(50, 50);

                    // Maintain transparency for PNG and GIF
                    if ($imageType === 'image/png' || $imageType === 'image/gif') {
                        imagealphablending($newImage, false);
                        imagesavealpha($newImage, true);
                        $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
                        imagefilledrectangle($newImage, 0, 0, 50, 50, $transparent);
                    }

                    // Resize the original image to 50x50
                    imagecopyresampled(
                        $newImage,        // Destination image
                        $sourceImage,     // Source image
                        0, 0,             // Destination x, y
                        0, 0,             // Source x, y
                        50, 50,           // Destination width, height
                        $originalWidth,   // Source width
                        $originalHeight   // Source height
                    );

                    // Save the resized image as PNG
                    if (imagepng($newImage, $newFileName)) {
                        imagedestroy($sourceImage);  // Free up memory
                        imagedestroy($newImage);     // Free up memory

                        $insert_sql = "INSERT INTO `stickers` (`id`, `storage`, `creator`, `extension`) VALUES (:id, 'local', :creator, 'png')";
                        $insert_stmt = $conn->prepare($insert_sql);
                        $insert_stmt->bindParam(':creator', $check_username);
                        $insert_stmt->bindParam(':id', $randomString);

                        if ($insert_stmt->execute()) {
                            echo json_encode([
                                "status" => 1,
                                "filename" => $randomString
                            ]);
                            exit();
                        } else {
                            echo json_encode(["status" => 0]);
                        }                
                    } else {
                        echo json_encode(["status" => 0]);
                    }
                } else {
                    echo json_encode(["status" => 0]);
                }
            } else {
                echo json_encode(["status" => 0]);
            }
        } else {
            echo json_encode(["status" => 0]);
        }
    } else {
        echo json_encode(["status" => 0]);
    }
}
?>

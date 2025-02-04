<?php
//Enable error reporting for development (remove in production)
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: content-type");
header("Access-Control-Allow-Methods: OPTIONS,GET,PUT,POST,DELETE");
header("Access-Control-Allow-Headers: x-api-key, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Content-type: application/json; charset=utf-8");
header("Access-Control-Allow-Methods: POST");

try {

    // Connect to the database
    require_once('database.php');
    if (!$conn) {
        throw new Exception('Database connection failed.');
    }

    // Read and validate the POST request body
    $input = json_decode(file_get_contents("php://input"));
    if (!isset($input['username']) || empty($input['username']) || !isset($input['offset']) || !is_numeric($input['offset'])) {
        throw new Exception('Invalid input.');
    }

    $userId = $input['username'];
    $section = max(1, intval($input['offset'])); // Ensure section is at least 1
    $limit = 6; // Number of messages per page
    $offset = ($section - 1) * $limit;

    // Fetch user details
    $sqlGetUserData = "
        SELECT username, color 
        FROM users 
        WHERE userId = :userId
    ";
    $stmtUser = $conn->prepare($sqlGetUserData);
    $stmtUser->bindParam(':userId', $userId);
    $stmtUser->execute();
    $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$userData) {
        throw new Exception('User not found.');
    }

    // Update user's last activity timestamp
    $sqlLastActivity = "
        UPDATE users 
        SET lastActivity = :lastActivity 
        WHERE userId = :userId
    ";
    $stmtActivity = $conn->prepare($sqlLastActivity);
    $lastActivity = (new DateTime())->format('Y-m-d H:i:s');
    $stmtActivity->bindParam(':userId', $userId);
    $stmtActivity->bindParam(':lastActivity', $lastActivity);
    $stmtActivity->execute();

    // Fetch chat messages with pagination
    $sqlChats = "
        SELECT 
            m.id, 
            m.sender, 
            m.receiver, 
            m.text,
            m.timestamp,
            u.color,
            (UNIX_TIMESTAMP() - UNIX_TIMESTAMP(u.lastActivity)) <= 120 AS active
        FROM messages m
        LEFT JOIN users u 
            ON u.username = (CASE 
                                WHEN m.sender = :username THEN m.receiver 
                                WHEN m.receiver = :username THEN m.sender 
                             END)
        WHERE 
            (m.sender = :username OR m.receiver = :username) 
        ORDER BY m.timestamp DESC
        LIMIT :offset, :limit
    ";
    $stmtChats = $conn->prepare($sqlChats);
    $stmtChats->bindParam(':username', $userData['username']);
    $stmtChats->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmtChats->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmtChats->execute();
    $chats = $stmtChats->fetchAll(PDO::FETCH_ASSOC);

    $isTheEnd = count($chats) < $limit; // Check if there are no more messages to load

    // Return response
    echo json_encode([
        'success' => true,
        'data' => [
            'user' => $userData,
            'chats' => array_reverse($chats), // Reverse order to display oldest first
            'isTheEnd' => $isTheEnd,
            'section' => $section,
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(200);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(200);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

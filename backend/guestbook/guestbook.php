<?php
require_once __DIR__ . '/../db/db_connect.php';

function getMessagesByBlockStatus($isBlocked) {
    $conn = getDbConnection();
    $blockStatus = $isBlocked ? 1 : 0;

    $sql = "
        SELECT g.id, g.user_id, g.name, g.message, g.created_at
        FROM guestbook g
        JOIN users u ON g.user_id = u.id
        WHERE u.is_blocked = ?
        ORDER BY g.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blockStatus);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $conn->close();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return json_encode($messages);
}


$isBlocked = isset($_GET['is_blocked']) ? filter_var($_GET['is_blocked'], FILTER_VALIDATE_BOOLEAN) : false;

header('Content-Type: application/json');
echo getMessagesByBlockStatus($isBlocked);
?>
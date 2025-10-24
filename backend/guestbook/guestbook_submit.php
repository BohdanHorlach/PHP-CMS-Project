<?php
session_start();
require_once __DIR__ . '/../db/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getDbConnection();
    $name = trim($_POST["name"]);
    $message = trim($_POST["message"]);
    $user_id = trim($_POST["user_id"]);

    $redirect_url = $_SERVER['HTTP_REFERER'] ?? "http://localhost/Projects/PHP-CMS-Project/frontend/guestbook/guestbook.php";

    if (!empty($name) && !empty($message)) {
        $stmt = $conn->prepare("SELECT is_blocked FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($is_blocked);
        $stmt->fetch();
        $stmt->close();

        if ($is_blocked) {
            $_SESSION["errors"] = ["Your account has been blocked. You cannot leave messages."];
            header("Location: $redirect_url");
            exit();
        }

        $stmt = $conn->prepare("INSERT INTO guestbook (user_id, name, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $name, $message);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        $_SESSION["success"] = "Your message has been added!";
    }
    
    header("Location: $redirect_url");
    exit();
}

header("Location: " . ($_SERVER['HTTP_REFERER'] ?? "http://localhost/Projects/PHP-CMS-Project/frontend/guestbook/guestbook.php"));
exit();
?>
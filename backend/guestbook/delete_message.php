<?php
session_start();
require_once __DIR__ . '/../db/db_connect.php';
require_once __DIR__ . '/../users/user_services.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

if(!isAdmin($user_id)){
    header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/about.php");
    exit();
}

if (isset($_GET["id"])) {
    $conn = getDbConnection();
    $id = $_GET["id"];

    $stmt = $conn->prepare("DELETE FROM guestbook WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION["success"] = "Message deleted!";
} else {
    $_SESSION["error"] = "Invalid request.";
}

header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/guestbook/moderate_guestbook.php");
exit();
?>
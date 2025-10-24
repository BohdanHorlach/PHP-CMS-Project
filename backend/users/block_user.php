<?php
session_start();
require_once __DIR__ . '/../db/db_connect.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/authorization/login.php");
    exit();
}

if (!isset($_GET["id"]) || !isset($_GET["block"])) {
    die("Incorrect parameters.");
}

$user_id = $_GET["id"];
$block = $_GET["block"] === 'true' ? 1 : 0;

$conn = getDbConnection();

$stmt = $conn->prepare("UPDATE users SET is_blocked = ? WHERE id = ?");
$stmt->bind_param("ii", $block, $user_id);
$stmt->execute();
$stmt->close();
$conn->close();

$_SESSION["success"] = $block ? "User blocked.“ : ”User unblocked.";
header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/guestbook/moderate_guestbook.php");
exit();
?>

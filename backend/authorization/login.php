<?php
session_start();
require_once __DIR__ . '/../db/db_connect.php';
require_once __DIR__ . '/../users/user_services.php';

$conn = getDbConnection();

$email = trim($_POST["email"]);
$password = $_POST["password"];

$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Incorect email";
}

if (empty($password)) {
    $errors[] = "Password cannot be empty";
}

if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/authorization/login.php");
    $conn->close();

    exit();
}


$sql = "SELECT id, password_hash FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();


if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $password_hash);
    $stmt->fetch();

    if (password_verify($password, $password_hash)) {
        $_SESSION["user_id"] = $user_id;
        $_SESSION["profile"] = getUserProfile($user_id);
        header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/index.php");
        $conn->close();

        exit();
    } else {
        $errors[] = "Incorrect password";
    }
} else {
    $errors[] = "User dont find";
}

$_SESSION["errors"] = $errors;
header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/authorization/login.php");
$conn->close();

exit();
?>

<?php
session_start();
require_once __DIR__ . '/../db/db_connect.php';

$conn = getDbConnection();

if ($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $errors = [];

    if (empty($name) || strlen($name) < 3) {
        $errors[] = "The name must contain at least 3 characters";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (strlen($password) < 6) {
        $errors[] = "The password must contain at least 6 characters.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "This email is already in use";
    }
    $stmt->close();

    if (!empty($errors)) {
        $_SESSION["errors"] = $errors;
        header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/authorization/register.php");
        $conn->close();

        exit();
    }

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password_hash);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION["success"] = "Registration successful! Log in to your account.";
    header("Location: http://localhost/Projects/PHP-CMS-Project/frontend/authorization/login.php");
    exit();
}
?>
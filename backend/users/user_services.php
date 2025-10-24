<?php
require_once __DIR__ . '/../db/db_connect.php';

function getUserProfile($user_id) {
    $conn = getDbConnection();
    $sql = "SELECT name, email, is_admin, is_blocked FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $email, $is_admin, $is_blocked);
    if ($stmt->fetch()) {
        $profile = [
            'user_id' => $user_id,
            'name' => $name,
            'email' => $email,
            'is_admin' => $is_admin,
            'is_blocked' => $is_blocked
        ];
    } else {
        $profile = null;
    }
    $stmt->close();
    $conn->close();
    return $profile;
}

function updateUserProfile($user_id, $name, $email) {
    $conn = getDbConnection();
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

function isAdmin($user_id){
    $profile = getUserProfile($user_id);
    
    return $profile && $profile['is_admin'] == true;
}
?>
<?php
require_once __DIR__ . '/user_services.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        $profile = getUserProfile($user_id);
        
        if ($profile) {
            echo json_encode(['status' => 'success', 'data' => $profile]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'user_id not provided']);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (isset($input['user_id'], $input['name'], $input['email'])) {
        $user_id = intval($input['user_id']);
        $name = trim($input['name']);
        $email = trim($input['email']);

        $result = updateUserProfile($user_id, $name, $email);
        $updatedProfileInfo = getUserProfile($user_id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Profile updated', 'profile' => $updatedProfileInfo]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Update error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect data']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Unsupported method']);
?>
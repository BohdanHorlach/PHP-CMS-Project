<?php
header("Content-Type: application/json");
require_once 'post_services.php';

$posts = getLastPosts(5);
echo json_encode(["success" => true, "posts" => $posts]);
?>
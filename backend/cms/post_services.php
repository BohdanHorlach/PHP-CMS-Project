<?php
require_once __DIR__ . '/../db/db_connect.php';

function addPost($title, $contents) {
    $conn = getDbConnection();
    $sql = "INSERT INTO posts (title, contents) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $contents);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}


function updatePost($id, $title, $contents) {
    $conn = getDbConnection();
    $sql = "UPDATE posts SET title = ?, contents = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $contents, $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}


function deletePost($id) {
    $conn = getDbConnection();
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();

    return $result;
}


function getPostById($id) {
    $conn = getDbConnection();
    $sql = "SELECT id, title, contents, created_at FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($id, $title, $contents, $created_at);
    if ($stmt->fetch()) {
        $post = ["id" => $id, "title" => $title, "contents" => $contents, "created_at" => $created_at];
    } else {
        $post = null;
    }
    $stmt->close();
    $conn->close();

    return $post;
}


function getAllPosts() {
    $conn = getDbConnection();
    $sql = "SELECT id, title, contents, created_at FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    $conn->close();

    return $posts;
}



function getLastPosts($limit = 5) {
    $conn = getDbConnection();
    $sql = "SELECT id, title FROM posts ORDER BY created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $posts;
}
?>
<?php
header("Content-Type: application/json");
require_once 'post_services.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];


$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($requestMethod) {
    case "GET":
        if ($id) {
            $post = getPostById($id);
            if ($post) {
                echo json_encode(["success" => true, "post" => $post]);
            } else {
                echo json_encode(["success" => false, "message" => "Post dont found"]);
            }
        } else {
            $posts = getAllPosts();
            echo json_encode(["success" => true, "posts" => $posts]);
        }
        break;

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["title"]) || !isset($data["contents"])) {
            echo json_encode(["success" => false, "message" => "No data available"]);
            exit();
        }

        $result = addPost($data["title"], $data["contents"]);
        echo json_encode(["success" => $result, "message" => $result ? "Post added" : "Error while adding"]);
        break;

    case "PUT":
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID not available"]);
            exit();
        }

        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data["title"]) || !isset($data["contents"])) {
            echo json_encode(["success" => false, "message" => "No data available"]);
            exit();
        }

        $result = updatePost($id, $data["title"], $data["contents"]);
        echo json_encode(["success" => $result, "message" => $result ? "Post updated" : "Error while updating"]);
        break;

    case "DELETE":
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID not available"]);
            exit();
        }

        $result = deletePost($id);
        echo json_encode(["success" => $result, "message" => $result ? "Post deleted" : "Error while deleting post"]);
        break;

    default:
        echo json_encode(["success" => false, "message" => "Method not found"]);
        break;
}
?>
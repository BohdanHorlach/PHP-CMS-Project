<?php

$posts = [];
$apiUrl = "http://localhost/Projects/PHP-CMS-Project/backend/cms/post_api.php";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);
if ($data["success"] && !empty($data["posts"])) {
    $posts = $data["posts"];
}


$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postId = $_POST["post_id"] ?? "";
    $title = trim($_POST["title"]);
    $contents = trim($_POST["contents"]);

    if (isset($_POST["delete"])) {
        if (!empty($postId)) {
            $deleteUrl = "$apiUrl?id=$postId";
            $options = [
                "http" => [
                    "method"  => "DELETE",
                    "header"  => "Content-Type: application/json"
                ]
            ];
            $context = stream_context_create($options);
            $response = file_get_contents($deleteUrl, false, $context);
            $result = json_decode($response, true);
            $message = $result["message"] ?? "Error while delete.";
        }
    } elseif (!empty($title) && !empty($contents)) {
        $postData = json_encode(["title" => $title, "contents" => $contents]);
        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => $postId ? "PUT" : "POST",
                "content" => $postData
            ]
        ];
        $context = stream_context_create($options);
        $saveUrl = $postId ? "$apiUrl?id=$postId" : $apiUrl;
        $response = file_get_contents($saveUrl, false, $context);
        $result = json_decode($response, true);
        $message = $result["message"] ?? "Error while saving.";
    } else {
        $message = "ERROR: The title or text cannot be empty.";
    }

    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}
?>

<script src="//cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<div>
    <form method="post">
        <label for="postSelect">Choose post:</label>
        <select id="postSelect" name="post_id" onchange="loadPostContent()">
            <option value="">New post</option>
            <?php foreach ($posts as $post): ?>
                <option value="<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <div class="my-4">
            <h3>Title</h3>
            <input class="form-control" type="text" id="title" name="title" placeholder="Input title">
            <div class="form-text">Name of title</div>
        </div>

        <div class="my-4">
            <h3>Content of post</h3>
            <textarea id="content" name="contents"></textarea>
            <div class="form-text">Content</div>
        </div>
        
        <br>
        <button class="btn btn-success" type="submit" id="saveButton">Save</button>
        <button class="btn btn-danger" type="submit" name="delete" id="deleteButton" disabled>Delete</button>
    </form>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
</div>

<script>
    CKEDITOR.replace('content', {
          width: "100%",
          height: "200px",
          filebrowserUploadUrl: "http://localhost/Projects/PHP-CMS-Project/ckeditor_fileupload/add_file.php?type=file",
          filebrowserImageUploadUrl: "http://localhost/Projects/PHP-CMS-Project/ckeditor_fileupload/add_file.php?type=image"
      }); 

    CKEDITOR.config.filebrowserUploadMethod = 'form';

    function loadPostContent() {
        const postId = document.getElementById("postSelect").value;
        if (!postId) {
            document.getElementById("title").value = "";
            CKEDITOR.instances.content.setData("");
            document.getElementById("deleteButton").disabled = true;
            return;
        }

        fetch(`<?= $apiUrl ?>?id=${postId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("title").value = data.post.title;
                    CKEDITOR.instances.content.setData(data.post.contents);
                    document.getElementById("deleteButton").disabled = false;
                }
            });
    }
</script>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function getPostById(int $id){
    $request = "http://localhost/Projects/PHP-CMS-Project/backend/cms/post_api.php?id=".$id;
    $response = file_get_contents($request);

    return json_decode($response, true);
}

function getLastPostsTitles(){
    $apiUrl = "http://localhost/Projects/PHP-CMS-Project/backend/cms/get_last_posts.php";
    $response = file_get_contents($apiUrl);

    return json_decode($response, true);
}


$postId = isset($_GET['id']) ? intval($_GET['id']) : 1;
$content = getPostById($postId);
$lastPosts = getLastPostsTitles();
?>

<body class="container p-4 px-5" data-bs-theme="<?php echo $_SESSION['theme']?>">
    <div class="container p-0 my-5">
        <h3>New posts</h3>
        <div class="d-flex justify-content-center">
            <?php foreach ($lastPosts["posts"] as $post): ?>
                <a class="mx-3" href=<?php echo "http://localhost/Projects/PHP-CMS-Project/frontend/index.php?id=".$post['id'] ?>><?= htmlspecialchars($post['title']) ?></a> |
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container p-0 my-5">

        <?php if($content['success'] == true): ?>
            <h1><?php echo $content['post']['title'] ?></h1>
            <div>
                <?php echo $content['post']['contents'] ?>
            </div>
        <?php else: ?>
            <h1><?php echo $content['message'] ?><h1>
        <?php endif ?>

    </div>
    <br>
    <?php include 'guestbook/guestbook.php'; ?>
</body>
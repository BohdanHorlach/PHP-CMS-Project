<?php
session_start();

if (!isset($_SESSION['profile'])) {
    header("Location: ../authorization/login.php");
    return;
}

$profile = $_SESSION['profile'];

if($profile['is_admin'] == false){
    echo "You are not administrator OR failed on load user data (try reload page).";
    return;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <title>CMS</title>
</head>
<?php include '../header.php'; ?>
<body class="d-flex flex-column min-vh-100" data-bs-theme="<?php echo $_SESSION['theme']?>">

    <div class="container-fluid py-2 start-0 my-3 bg-dark">
        <h1 class="text-white" style="display: inline; position: relative; left: 8%;">CMS</h1>
    </div>
    
    <main class="container flex-grow-1 py-4 px-4">
        <?php include 'post_editor.php'; ?>
    </main>
</body>
<?php include '../footer.php'; ?>
</html>
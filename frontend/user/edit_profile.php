<?php
session_start();

require_once __DIR__. '/services/user_services.php';

global $message;

if (!isset($_SESSION['profile'])) {
    header("Location: ../authorization/login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUser();
}

function updateUser(){
    global $message;

    if (isset($_POST['user_id'], $_POST['name'], $_POST['email'])) {
        $user_id = intval($_POST['user_id']);
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        $result = updateProfile($user_id, $name, $email);

        if ($result) {
            $message = "Profile successfully updated!";
            $_SESSION['profile'] = $result['profile'];
            $profile = $_SESSION['profile'];
        } else {
            $message = "Error updating profile. Please try again.";
        }
    } else {
        $message = "Incorrect data for updating your profile.";
    }
}

$profile = $_SESSION['profile'];

if (empty($profile)) {
    die("Unable to load profile.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>User profile</title>
</head>
<body class="container py-4 px-1 vh-100 d-flex justify-content-center" data-bs-theme="<?php echo $_SESSION['theme'] ?>">
    <div class="d-flex align-items-center">
        <div class="d-flex flex-column align-items-center">
            <h2>Edit profile</h2>
            <form class="my-4" action="" method="post">
                <input type="hidden" name="user_id" value="<?php echo $profile['user_id']; ?>">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $profile['name']; ?>" required>
                <div class="form-text">Your current name.</div>
                <br>
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $profile['email']; ?>" required>
                <div class="form-text">Your email.</div>
                <br>
                <div class="container text-center">
                    <button class="my-2 btn btn-success" type="submit">Save</button>
                </div>
            </form>
            <?php echo $message ?>

            <p><a href="../index.php">Home.</a></p>
            <p><a href="../authorization/logout.php">Log out</a></p>
        </div>
    </div>
</body>
</html>
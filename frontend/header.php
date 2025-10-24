<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['toggle_theme'])) {
    $_SESSION['theme'] = (isset($_SESSION['theme']) && $_SESSION['theme'] === 'dark') ? 'light' : 'dark';

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = 'light';
}

$profile = isset($_SESSION['profile']) ? $_SESSION['profile'] : "";
?>

<header>
    <div class="container pt-4 pb-2 px-4">
        <div class="d-flex justify-content-between">
            <div class="col text-start">
                <?php if(!empty($profile)): ?>
                    <span>Hi <?php echo $profile['name']; ?></span>
                <?php endif?>
            </div>
            <div class="col text-end flex-fill">
                <form method="post" action="" class="d-inline">
                    <button type="submit" name="toggle_theme" class="btn btn-outline-secondary me-3">
                        Switch theme
                    </button>
                </form>
                <?php if(!empty($profile)): ?>
                    <a href="http://localhost/Projects/PHP-CMS-Project/frontend/user/edit_profile.php" class="me-3">Profile</a>
                    <a href="http://localhost/Projects/PHP-CMS-Project/frontend/authorization/logout.php">Log out</a>
                <?php else:?>
                    <a href="http://localhost/Projects/PHP-CMS-Project/frontend/authorization/login.php" class="me-3">Log in</a>
                <?php endif?>
            </div>
        </div>
    </div>
</header>
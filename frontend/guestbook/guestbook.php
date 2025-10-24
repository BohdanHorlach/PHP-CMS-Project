<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__. '/../user/services/user_services.php';
require_once __DIR__. '/services/guestbook_services.php';

// Check for authorization
if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];

    if (empty($profile)) {
        echo "Failed on load profile.";
        return;
    }
}

$guestbook = getGuestbookList();
?>

<div class="px-4">
    <h2 class="mb-5">Guestbook</h2>

    <?php if (!isset($_SESSION["profile"])): ?>
        <?php echo "<p>For add comments, you need be <a href='authorization/login.php'>authorization</a>.</p>"; ?>
    <?php else: ?>
        <form action='http://localhost/Projects/PHP-CMS-Project/backend/guestbook/guestbook_submit.php' method="post">
            <div class="mb-3 p-3 form-control">
                <label for="disabledTextInput" class="form-label">Name</label>
                <input type="text" id="disabledTextInput" class="form-control" placeholder="<?php echo ($profile['name']); ?>" disabled>

                <input type="hidden" name="user_id" value="<?php echo ($profile['user_id']); ?>">
                <input type="hidden" name="name" value="<?php echo ($profile['name']); ?>">

                <?php if ($profile['is_blocked'] == false): ?>
                    <label for="disabledTextInput" class="mt-3 form-label">Message:</label>
                    <div class="mb-3"> 
                        <textarea class="form-control" rows="5" name="message"  placeholder="Input your message" required></textarea> 
                    </div>
                    <button class="my-2 btn btn-outline-success" type="submit">Send</button>
                <?php else: ?>
                    <p>You blocked</p>
                    <p>Contact the administration</p>
                <?php endif; ?>
            </div>
        </form>
    <?php endif; ?>
    <h4>Last messages:</h4>
    <ul>
        <?php if (empty($guestbook)): ?>
            <p>No messages in the guestbook.</p>
        <?php else: ?>
            <div class="container">
                <?php foreach ($guestbook as $msg): ?>
                    <div class="my-3 p-3 border border-3 rounded-3">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo htmlspecialchars($msg['name']); ?></h5>
                            <small><?php echo $msg['created_at']; ?></small>
                        </div>
                        <p class="mb-1"><?php echo htmlspecialchars($msg['message']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </ul>
</div>

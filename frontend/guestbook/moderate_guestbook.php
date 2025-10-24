<?php
session_start();

require_once __DIR__. '/../user/services/user_services.php';
require_once __DIR__. '/services/guestbook_services.php';

if (!isset($_SESSION['profile'])) {
    header("Location: ../authorization/login.php");
    return;
}

$profile = $_SESSION['profile'];

if($profile['is_admin'] == false){
    echo "You are not an administrator OR the profile could not be loaded.";
    return;
}

$guestbook_non_blocked = getGuestbookList(false);
$guestbook_blocked = getGuestbookList(true);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Guestbook moderation</title>
</head>
<div>
    <h2>Guestbook moderation</h2>

    <h3>Guestbook</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Message</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guestbook_non_blocked as $msg): ?>
            <tr>
                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                <td><?php echo htmlspecialchars($msg['message']); ?></td>
                <td><?php echo htmlspecialchars($msg['created_at']); ?></td>
                <td>
                    <a href="http://localhost/Projects/PHP-CMS-Project/backend/guestbook/delete_message.php?id=<?php echo $msg['id']; ?>">Delete</a> |
                    <a href="http://localhost/Projects/PHP-CMS-Project/backend/users/block_user.php?id=<?php echo $msg['user_id']; ?>&block=true">Block user</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Blocked usres:</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Message</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($guestbook_blocked as $msg): ?>
            <tr>
                <td><?php echo htmlspecialchars($msg['name']); ?></td>
                <td><?php echo htmlspecialchars($msg['message']); ?></td>
                <td><?php echo htmlspecialchars($msg['created_at']); ?></td>
                <td>
                    <a href="http://localhost/Projects/PHP-CMS-Project/backend/guestbook/delete_message.php?id=<?php echo $msg['id']; ?>">Delete</a> |
                    <a href="http://localhost/Projects/PHP-CMS-Project/backend/users/block_user.php?id=<?php echo $msg['user_id']; ?>&block=false">Unblock user</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p><a href="../index.php">Main page</a></p> 
</div>
</html>

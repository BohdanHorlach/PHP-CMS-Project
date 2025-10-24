<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Registration</title>
</head>
<body class="container py-4 px-1 vh-100 d-flex justify-content-center">
    <div class="d-flex align-items-center">
        <div class="d-flex flex-column align-items-center">
            <h2>Registration form</h2>

            <?php
            session_start();
            if (isset($_SESSION["errors"])) {
                echo "<ul style='color: red;'>";
                foreach ($_SESSION["errors"] as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
                unset($_SESSION["errors"]);
            }
            ?>

            <form class="my-4" action="http://localhost/Projects/PHP-CMS-Project/backend/authorization/registration.php" method="post">
                <label class="form-label">Name:</label>
                <input class="form-control" name="name" required>
                <label class="form-label">Email:</label>
                <input class="form-control" name="email" required>
                <br>
                <label class="form-label">Password:</label>
                <input class="form-control" type="password" name="password" required>
                <label class="form-label">Confirm password:</label>
                <input class="form-control" type="password" name="confirm_password" required>
                <br>
                <div class="container text-center">
                    <button class="btn btn-primary" type="submit">Registrate</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

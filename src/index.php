<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");

if (Auth::isLoggedIn()) {
    header("Location: userpanel.php");
    exit;
}

// TODO: error messages
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <title>Login Page</title>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <div class="form-row m-1 p-1">
        <img class="m-1 p-1"
             src="https://resources.jetbrains.com/storage/products/phpstorm/img/meta/phpstorm_logo_300x300.png"
             width="50" height="50">
    </div>
    <form action="controller/auth/login.php" method="post">
        <div class="form-row m-1 p-1">
            <?php
            if (isset($_SESSION) && isset($_SESSION["msg"])) {
                echo $_SESSION["msg"];
                unset($_SESSION["msg"]);
            }
            ?>
            <div class="input-group mt-2">
                <input class="form-control" type="text" name="username" placeholder="Username" required>
                <input class="form-control" type="password" name="password" placeholder="Password" required>
            </div>
            <input class="btn btn-success form-control mt-2" type="submit" value="login">
            <a href="registration.php"><input class="btn btn-warning form-control mt-2" type="button"
                                              value="create account"/></a>
        </div>
    </form>
</div>
</body>
</html>

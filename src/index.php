<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

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
<body>
<div id="container">
    <div id="loginPanel">
        <table>
            <form action="controller/Auth/login.php" method="post">
                <tr>
                    <th>
                        <input type="text" name="username" placeholder="Username">
                    </th>
                    <th>
                        <input type="password" name="password" placeholder="Password">
                    </th>
                </tr>
                <tr>
                    <th>
                        <input type="submit" value="login">
                    </th>
                    <th>
                        <a href="registration.php">
                            <input type="button" value="create account"/>
                        </a>
                    </th>
                </tr>
            </form>
        </table>
    </div>
</div>
</body>
</html>

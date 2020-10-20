<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <title>Change Password</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");

    if (!Auth::isLoggedIn()) {
        header("Location: index.php");
        exit;
    }
    ?>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <form action="accountoverview.php">
        <div class="form-row m-1 p-1">
            <div class="form-control bg-dark">
                <input class="btn btn-warning" type="submit" value="back to account overview">
            </div>
        </div>
    </form>
    <form action="controller/auth/changepassword.php" method="post">
        <div class="form-row m-1 p-1">
            <?php
            if (isset($_SESSION) && isset($_SESSION["msg"])) {
                echo $_SESSION["msg"];
                unset($_SESSION["msg"]);
            }
            ?>
            <div class="input-group mt-2">
                <input class="form-control" type="password" name="curPassword" placeholder="Current Password" required>
                <input class="form-control" type="password" name="newPassword" placeholder="New Password" required>
                <input class="form-control" type="password" name="passwordConfirm" placeholder="Confirm New Password"
                       required>
            </div>
            <div class="input-group" role="group">
                <input class="btn btn-success form-control mt-2" type="submit" value="submit">
            </div>
        </div>
    </form>
</div>
</body>
</html>
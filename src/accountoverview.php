<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <title>Account Overview</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

    if (!Auth::isLoggedIn()) {
        header("Location: index.php");
        exit;
    }
    ?>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <form action="index.php">
        <div class="form-row m-1 p-1">
            <div class="form-control bg-dark">
                <input class="btn btn-warning" type="submit" value="back to user panel">
            </div>
        </div>
    </form>
    <div class="form-row m-1 p-1">
        <form action="inviteoverview.php" method="post">
            <div class="input-group mt-2">
                <button class="form-control btn-primary text-white" name="curPassword">Invites</button>
            </div>
        </form>
        <form action="controller/Auth/changepassword.php" method="post">
            <div class="input-group mt-2">
                <button class="form-control btn-danger text-white" name="curPassword">Change Password</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
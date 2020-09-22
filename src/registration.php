<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

    if (Auth::isLoggedIn()) {
        header("Location: userpanel.php");
        exit;
    }
    ?>
</head>
<body>
<div id="container">
    <div id="topControls">
        <table id="child" border="1">
            <tr>
                <th>
                    <form action="index.php">
                        <input type="submit" value="back to login">
                    </form>
                </th>
            </tr>
        </table>
    </div>
    <table border="1" class="child">
        <form action="controller/Auth/register.php" method="post">
            <tr>
                <th><label>Username: </label></th>
                <th><input type="text" name="username" required><br></th>
            </tr>
            <tr>
                <th><label>Password: </label></th>
                <th><input type="password" name="password" required><br></th>
            </tr>
            <tr>
                <th><label>Confirm Password: </label></th>
                <th><input type="password" name="passwordConfirm" required><br>
                </th>
            </tr>
            <th>
                <tr>
                    <th><input type="submit" value="register account"></th>
                    <th></th>
                </tr>
        </form>
    </table>
</div>
</body>
</html>
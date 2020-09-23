<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <title>User Panel</title>
</head>
<body>
<?php echo "Username: ".$_SESSION["username"] ?>
<form action="controller/Auth/logout.php">
    <input type="submit" value="logout">
</form>
</body>
</html>
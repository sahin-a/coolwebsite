<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

$username = $_POST["username"];
$password = $_POST["password"];

if (isset($username) && isset($password)) {
    session_start();

    if (Auth::validate_credentials($username, $password)) {
        $_SESSION["loggedIn"] = true;
        //$_SESSION["username"] = $username;

        header("Location: ../../userpanel.php");
        exit;
    }
    $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Wrong credentials");
}

header("Location: ../../index.php");
exit;


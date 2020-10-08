<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}
$curPassword = $_POST["curPassword"];
$newPassword = $_POST["newPassword"];
$passwordConfirm = $_POST["passwordConfirm"];

$username = $_SESSION["user"]["username"];

if (isset($username) && isset($curPassword) && isset($newPassword) && isset($passwordConfirm)) {
    if (strcmp($newPassword, $passwordConfirm) === 0) {
        if (Auth::update_password($username, $curPassword, $newPassword)) {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Successfully to updated your password :)");
        } else {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Failed to update your password :/");
        }
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Passwords don't match :/");
    }
}

header("Location: ../../changepassword.php");
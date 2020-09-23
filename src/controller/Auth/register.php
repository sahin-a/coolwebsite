<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

$username = $_POST["username"];
$password = $_POST["password"];
$passwordConfirm = $_POST["passwordConfirm"];

if (isset($username) && isset($password) && isset($passwordConfirm)) {
    session_start();

    if ($password === $passwordConfirm) {
        if (Auth::register_account($username, $password)) {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "Account creation was successful :)");
        } else {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to register your account :(");
        }
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Passwords don't match :/");
    }

    header("Location: ../../registration.php");
}
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

$username = $_POST["username"];
$password = $_POST["password"];

if (isset($username) && isset($password)) {
    if (Auth::register_account($username, $password)) {
        header("Location: ../../index.php");
        exit;
    }
}
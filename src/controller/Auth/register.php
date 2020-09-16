<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/src/controller/Auth/Auth.php";

$username = $_POST["username"];
$password = $_POST["password"];

printf("START");
// TODO: weiterleiten
if (isset($username) && isset($password)) {
    if (Auth::register_account($username, $password)) {
        printf("SUCCESS");
    }
} else {
    printf("ERROR");
}

printf("END");
die();
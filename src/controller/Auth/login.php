<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/src/controller/Auth/Auth.php";

$username = $_POST["username"];
$password = $_POST["password"];

printf("START");

if (isset($username) && isset($password)) {
    if (Auth::validate_creds($username, $password)) {
        // login successful
      printf("SUCCESS");
    }
} else {
    printf("ERROR");
}

printf("END");
die();
<?php
/*
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/Token.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTLib.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");

$jwt = new JWTLib();
$bearerToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOjMsInVzZXJuYW1lIjoic2FoaW4iLCJpYXQiOjE2MDMxOTcwNjksImV4cCI6MTYwMzIwMDY2OX0.e75e5c57886caf24a03651216478dfd8e9ca6c7f9581cc443b288848aa4468fe";

if ($token = JWTUtils::validate_token($bearerToken, "test")) {
    echo json_encode(array("msg" => "success",
        "user" => array("uid" => $token["uid"], "username" => $token["username"])), JSON_PRETTY_PRINT);
} else {
    echo json_encode(array("msg" => "fail"), JSON_PRETTY_PRINT);
}

http_response_code(200);
header('Content-Type: application/json');
*/
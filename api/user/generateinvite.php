<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/JsonMessage.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => JsonMessage::UNAUTHORIZED));
    exit;
}

$uid = $_SESSION["user"]["uid"];

if (Auth::generate_invite($uid)) {
    echo json_encode(array("message" => "successfully generated invite code"));
} else {
    echo json_encode(array("message" => "failed to generate invite code"));
}

header('Content-Type: application/json');
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/JsonEndpointMsg.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION["user"]["username"];
$id = $_POST["id"];
$comment = isset($_POST["comment"]) ? htmlspecialchars($_POST["comment"]) : null;

$con = DatabaseCollector::getInstance()->getConnection();
$query = "INSERT INTO commentSections (id, username, comment) VALUES(?, ?, ?)";

if (isset($id) && isset($username) && isset($comment)) {
    $result = DatabaseCollector::execute_sql_query($query, "iss", false, $id, $username, $comment);

    if ($result) {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "comment has been added successfully");
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to add entry to table");
    }
} else {
    $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Comment can't be empty!");
}
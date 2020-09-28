<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

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
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, "iss", $id, $username, $comment);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "comment has been added successfully");
        } else {
            $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to add entry to table");
        }
    }
} else {
    $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Comment can't be empty!");
}
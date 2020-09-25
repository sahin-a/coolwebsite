<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

//if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
//}

$username = $_POST["username"];
$comment = isset($_POST["comment"]) ? htmlspecialchars($_POST["comment"]) : null;
$videoId = $_POST["videoId"];

$con = DatabaseCollector::getInstance()->getConnection();
$query = "INSERT INTO commentSections (videoId, username, comment) VALUES(?, ?, ?)";

if ($stmt = mysqli_prepare($con, $query)) {
    mysqli_stmt_bind_param($stmt, "sss", $videoId, $username, $comment);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "Video has been added successfully");
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to add entry to table");
    }
}
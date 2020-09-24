<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$pattern = "/^((http|https):\/\/(www.youtube.com\/watch\?v=|youtu.be\/)([a-zA-Z0-9_-]{11}))/";

$videoUrl = $_POST["videoUrl"];
$message = $_POST["message"];
$user = $_SESSION["user"];
$submitter = $user["username"];

if (isset($videoUrl)) {
    if (preg_match($pattern, $videoUrl, $matches)) {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO youtubeVideos (submitter, videoId, message) VALUES(?, ?, ?)";
        $videoId = $matches[4];

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $submitter, $videoId, $message);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "Video has been added successfully");
            } else {
                $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to add entry to table");
            }
        }
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Invalid YouTube Url");
    }
} else {
    $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Video Url is empty/null");
}

header("Location: ../../userpanel.php");
exit;

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$pattern = "/^((http|https):\/\/(www.youtube.com\/watch\?v=|youtu.be\/)([a-zA-Z0-9_-]{11}))/";

$videoUrl = $_POST["videoUrl"];
$message = isset($_POST["message"]) ? htmlspecialchars($_POST["message"]) : null;
$uid = $_SESSION["user"]["uid"];

if (isset($videoUrl)) {
    if (preg_match($pattern, $videoUrl, $matches)) {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO youtubeVideos (uid, videoId, message) VALUES(?, ?, ?)";
        $videoId = $matches[4];

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $uid, $videoId, $message);

            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::SUCCESS, "Video has been added successfully");
            } else {
                $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Failed to add entry to table");
            }
        }
    } else {
        $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::DANGER, "Invalid youtube Url");
    }
} else {
    $_SESSION["msg"] = AlertBuilder::buildAlert(AlertType::WARNING, "Video Url is empty/null");
}

header("Location: ../../userpanel.php");
exit;

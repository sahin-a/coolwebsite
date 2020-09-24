<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");

$con = DatabaseCollector::getInstance()->getConnection();
$query = "SELECT * FROM youtubeVideos";
$videos = array();

if ($stmt = mysqli_prepare($con, $query)) {
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $submitter = $row["submitter"];
            $videoId = $row["videoId"];
            $message = $row["message"];
            $submit_date = $row["submit_date"];

            if (isset($submitter) && isset($videoId) && isset($submit_date)) {
                $video = array(
                    "submitter" => $submitter,
                    "videoId" => $videoId,
                    "message" => $message,
                    "submit_date" => $submit_date
                );

                array_push($videos, $video);
            }
        }
        echo json_encode($videos, JSON_PRETTY_PRINT);
        header('Content-Type: application/json');
    }
}
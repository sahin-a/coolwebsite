<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => "unauthorized access"));
} else {
    $con = DatabaseCollector::getInstance()->getConnection();
    $query = "SELECT users.username, youtubeVideos.* FROM users INNER JOIN youtubeVideos ON users.id = youtubeVideos.uid ORDER BY submit_date DESC";
    $videos = array();

    if ($stmt = mysqli_prepare($con, $query)) {
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                $submitter_id = $row["uid"];
                $submitter = $row["username"];

                $id = $row["id"];
                $videoId = $row["videoId"];
                $message = $row["message"];
                $submit_date = $row["submit_date"];

                if (isset($submitter_id) && isset($submitter) && isset($videoId) && isset($submit_date)) {
                    $video = array(
                        "id" => $id,
                        "submitter_id" => $submitter_id,
                        "submitter" => $submitter,
                        "videoId" => $videoId,
                        "message" => $message,
                        "submit_date" => $submit_date
                    );

                    array_push($videos, $video);
                }
            }

            $count = count($videos);

            if ($count > 0) {
                http_response_code(200);
                echo json_encode(array("message" => "successfully retrieved the video list",
                    "count" => $count,
                    "videos" => $videos),
                    JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "no videos found"), JSON_PRETTY_PRINT);
            }
        }
    }
}

header('Content-Type: application/json');
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/databasecollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/JsonEndpointMsg.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => JsonEndpointMsg::UNAUTHORIZED));
} else {
    $con = DatabaseCollector::getInstance()->getConnection();
    $query = "SELECT users.username, youtubeVideos.* FROM users INNER JOIN youtubeVideos 
            ON users.id = youtubeVideos.uid ORDER BY submit_date DESC";
    $videos = array();
    $rows = DatabaseCollector::execute_sql_query($query, null, true, null);

    $count = count($rows);

    if ($count > 0) {
        foreach ($rows as $row) {
            $submitter_id = $row["uid"];
            $submitter = $row["username"];

            $id = $row["id"];
            $videoId = $row["videoId"];
            $message = $row["message"];
            $submit_date = $row["submit_date"];

            if (isset($submitter_id) && isset($submitter) && isset($id) && isset($videoId) && isset($message)
                && isset($submit_date)) {

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

header('Content-Type: application/json');
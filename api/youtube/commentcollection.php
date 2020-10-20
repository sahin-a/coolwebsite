<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/databasecollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/JsonMessage.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => JsonMessage::UNAUTHORIZED));
} else {
    if (isset($_POST["id"])) {
        $query = "SELECT * FROM commentSections WHERE BINARY id=?";
        $rows = DatabaseCollector::execute_sql_query($query, "i", true, $_POST["id"]);
        $comments = array();
        $count = count($rows);

        if ($count > 0) {
            foreach ($rows as $row) {
                $id = $row["id"];
                $username = $row["username"];
                $comment = $row["comment"];
                $creation_date = $row["creation_date"];

                if (isset($id) && isset($username) && isset($comment) && isset($creation_date)) {
                    $comment = array(
                        "id" => $id,
                        "username" => $username,
                        "comment" => $comment,
                        "creation_date" => $creation_date
                    );

                    array_push($comments, $comment);
                }
            }

            http_response_code(200);
            echo json_encode(array("message" => "successfully retrieved comments",
                "count" => $count,
                "comments" => $comments),
                JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "no comments found"), JSON_PRETTY_PRINT);
        }
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "video id equals null"), JSON_PRETTY_PRINT);
    }
}

header('Content-Type: application/json');
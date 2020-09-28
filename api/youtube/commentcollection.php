<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => "unauthorized access"));
} else {
    if (isset($_POST["id"])) {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT * FROM commentSections WHERE BINARY id=?";
        $comments = array();

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $_POST["id"]);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
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

                $count = count($comments);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(array("message" => "successfully retrieved comments",
                        "count" => $count,
                        "comments" => $comments),
                        JSON_PRETTY_PRINT);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "no comments found"), JSON_PRETTY_PRINT);
                }
            }
        }
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "video id equals null"), JSON_PRETTY_PRINT);
    }
}

header('Content-Type: application/json');
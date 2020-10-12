<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/JsonMessage.php");

if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(array("message" => JsonMessage::UNAUTHORIZED));
} else {
    $id = $_SESSION["user"]["uid"];

    if (isset($id)) {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT users.id, users.username, invites.invite_code, invites.creation_date FROM users 
                 INNER JOIN invites ON users.id = invites.uid WHERE users.id=?";
        $rows = DatabaseCollector::execute_sql_query($query, "i", true, $id);
        $count = count($rows);

        if ($count > 0) {
            $invites = array();

            foreach ($rows as $row) {
                $id = $row["id"];
                $username = $row["username"];
                $inviteCode = $row["invite_code"];
                $creation_date = $row["creation_date"];

                if (isset($id) && isset($username) && isset($inviteCode) && isset($creation_date)) {
                    $invite = array(
                        "id" => $id,
                        "username" => $username,
                        "invite_code" => $inviteCode,
                        "creation_date" => $creation_date
                    );

                    array_push($invites, $invite);
                }
            }

            http_response_code(200);
            echo json_encode(array("message" => "successfully retrieved invites",
                "count" => $count,
                "invites" => $invites),
                JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "no invites found"), JSON_PRETTY_PRINT);
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "uid equals null"));
    }
}

header('Content-Type: application/json');
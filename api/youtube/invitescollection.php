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
        $inviteCodes = array();

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $username = $row["username"];
                    $inviteCode = $row["invite_code"];
                    $creation_date = $row["creation_date"];

                    if (isset($id) && isset($username) && isset($inviteCode) && isset($creation_date)) {
                        $inviteCode = array(
                            "id" => $id,
                            "username" => $username,
                            "invite_code" => $inviteCode,
                            "creation_date" => $creation_date
                        );

                        array_push($inviteCodes, $inviteCode);
                    }
                }

                $count = count($inviteCodes);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(array("message" => "successfully retrieved invites",
                        "count" => $count,
                        "invites" => $inviteCodes),
                        JSON_PRETTY_PRINT);
                } else {
                    http_response_code(404);
                    echo json_encode(array("message" => "no invites found"), JSON_PRETTY_PRINT);
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "sql query failed"));
            }
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "id equals null"));
    }
}

header('Content-Type: application/json');
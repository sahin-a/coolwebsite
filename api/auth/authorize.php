<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/Token.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTLib.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if ($user = Auth::validate_credentials($_POST["username"], $_POST["password"], false)) {
        $token = Token::createValidToken($user["uid"], $user["username"]);

        // TODO: find out how to properly store the secret

        $jwt = new JWTLib();
        $bearerToken = $jwt::createToken($token, "Tx5RrVBz8akwSaBUmNAY7QWx"); // test secret

        /*if (DatabaseCollector::execute_sql_query("INSERT INTO tokens (uid, token) VALUES(?, ?)",
            "is", false, $token->getUid(), $token));*/

        echo json_encode(array("msg" => "successfully created token", "token_type" => "bearer",
            "expires_in" => $token->getExpiresIn(), "access_token" => $bearerToken), JSON_PRETTY_PRINT);

        http_response_code(200);
    } else {
        echo json_encode(array("msg" => "invalid credentials"), JSON_PRETTY_PRINT);

        http_response_code(400);
    }
} else {
    echo json_encode(array("msg" => "invalid post data"), JSON_PRETTY_PRINT);

    http_response_code(404);
}

header('Content-Type: application/json');
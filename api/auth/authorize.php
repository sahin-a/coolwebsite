<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/token/Payload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/ratelimiter/RateLimiter.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/token/Token.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTConverter.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/enums/JWTType.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/enums/JWTAlgs.php");

if (isset($_POST["username"]) && isset($_POST["password"])) {
    if ($user = Auth::validate_credentials($_POST["username"], $_POST["password"], false)) {
        $rateLimiter = new RateLimiter($user["uid"]);

        if (!$rateLimiter->isRateLimited(RequestLimitType::MAX_TOKEN_REQUESTS)) {

            // TODO: find out how to properly store the secret :(
            $token = Token::createValidToken($user["uid"], $user["username"]);

            echo json_encode(array
            (
                "msg" => "successfully created token",
                "token_type" => "bearer",
                "expires_in" => $token->getPayload()->getExpiresIn(),
                "access_token" => $token->tokenToJwt($token)
            ), JSON_PRETTY_PRINT);

            http_response_code(200);

        } else {
            echo json_encode(array("msg" => JsonEndpointMsg::RATE_LIMITED), JSON_PRETTY_PRINT);
        }
    } else {
        echo json_encode(array("msg" => JsonEndpointMsg::INVALID_CREDENTIALS), JSON_PRETTY_PRINT);

        http_response_code(400);
    }
} else {
    echo json_encode(array("msg" => JsonEndpointMsg::INVALID_DATA), JSON_PRETTY_PRINT);

    http_response_code(404);
}

header('Content-Type: application/json');
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTBuilder.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");

class JWTLib
{
    public static function convertTokenToString(Token $token, string $secret) : string
    {
        $builder = new JWTBuilder($token);
        $token = $builder->build($secret);

        return $token;
    }
}
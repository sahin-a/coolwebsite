<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/exceptions/ExpiredTokenException.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/exceptions/InvalidSignatureException.php");


class JWTUtils
{
    public static function base64url_encode(string $value)
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($value));
    }

    public static function base64url_decode(string $value)
    {
        return str_replace(['-', '_', ''], ['+', '/', '='], base64_decode($value));
    }
}
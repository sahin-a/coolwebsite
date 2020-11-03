<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/exceptions/ExpiredTokenException.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/exceptions/InvalidSignatureException.php");


class JWTUtils
{
    /**
     * base64url encode
     * @param string $value
     * @return string
     */
    public static function base64url_encode(string $value) : string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($value));
    }

    /**
     * base64url decode
     * @param string $value
     * @return string
     */
    public static function base64url_decode(string $value) : string
    {
        return str_replace(['-', '_', ''], ['+', '/', '='], base64_decode($value));
    }
}
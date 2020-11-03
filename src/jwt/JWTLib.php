<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTBuilder.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");

class JWTLib
{
    /**
     * convert the Token Object to the encoded jwt token
     * @param Token $token
     * @param string $secret
     * @return string
     */
    public static function convertTokenToString(Token $token, string $secret) : string
    {
        $builder = new JWTBuilder($token);
        $token = $builder->build($secret);

        return $token;
    }
}
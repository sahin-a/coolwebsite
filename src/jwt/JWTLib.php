<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/JWTBuilder.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");

class JWTLib
{
    public static function createToken(Token $token, string $secret) : string
    {
        $uid = $token->getUid();

        $builder = new JWTBuilder($token);
        $token = $builder->build($secret);

        if (DatabaseCollector::execute_sql_query("INSERT INTO tokens (uid, token) VALUES(?, ?)",
            "is", false, $uid, $token));

        return $token;
    }
}
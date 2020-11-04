<?php


class Secret
{
    private static string $secret = "Tx5RrVBz8akwSaBUmNAY7QWxSolSn";

    public static function getSecret()
    {
        return self::$secret;
    }
}
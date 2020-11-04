<?php


class JWTAlgs
{
    private function __construct() {}

    public const HS256 = "HS256";

    public static function parseAlgo($alg): string
    {
        switch ($alg) {
            case JWTAlgs::HS256:
                return "sha256";
            default:
                return "";
        }
    }
}
<?php


class Utils
{
    public static function getRequestLocation() : string {
        return basename($_SERVER["REQUEST_URI"], ".php");
    }
}
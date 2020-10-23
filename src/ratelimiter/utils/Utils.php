<?php


class Utils
{
    public static function getRequestLocation() : string {
        $location = basename($_SERVER["REQUEST_URI"], ".php");
        $location = substr_replace($location, "", strpos($location, "?"));

        return $location;
    }
}
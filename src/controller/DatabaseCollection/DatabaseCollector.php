<?php


class DatabaseCollector
{
    private static $host = "localhost";
    private static $user = "root";
    private static $password = "";
    private static $db = "SMJ_DB";
    private static $port = "3306";
    private static $socket = null;
    private static $con = null;

    private function __construct() {}

    private function getConnection()
    {
        if (!isset($con)) {
            $con = mysqli_connect(self::$host, self::$user, self::$password, self::$db, self::$port) or die("MySQL Connection failed");
        }

        return con;
    }
}
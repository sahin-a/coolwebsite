<?php


class DatabaseCollector
{
    private const DB_HOST = "localhost";
    private const DB_USER = "root";
    private const DB_PW = "";
    private const DB_NAME = "SMJ_DB";
    private const DB_PORT = "3306";
    private const DB_SOCKET = null;

    private static ?DatabaseCollector $instance = null;
    private static ?mysqli $con = null;

    private function __construct()
    {
        self::$con = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PW, self::DB_NAME);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return self::$con;
    }
}
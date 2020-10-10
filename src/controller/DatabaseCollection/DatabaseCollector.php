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

    /**
     * @param string $query
     * @param string $types
     * @param bool $res whether or not you want it to return the result from the query or a boolean
     * @param mixed ...$params
     * @return bool
     */
    public static function execute_sql_query(string $query, $types, bool $res, ...$params)
    {
        $con = self::getInstance()->getConnection();
        $rows = array();

        if ($stmt = mysqli_prepare($con, $query)) {
            if (isset($types) && isset($params))
                mysqli_stmt_bind_param($stmt, $types, ...$params);

            if ($stmt->execute()) {
                if (!$res)
                    return true;

                do {
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    array_push($rows, $row);
                } while ($stmt->next_result());

                return $rows;
            }
        }

        if ($res)
            return null;
        else
            return false;
    }
}
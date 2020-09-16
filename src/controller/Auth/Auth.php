<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");

class Auth
{
    public static function validate_credentials($username, $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT password FROM users WHERE username=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $storedHash = $row['password'];

                if (password_verify($password, $storedHash))
                    return true;
            }
        }

        return false;
    }

    public static function register_account($username, $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO users (username, password) VALUES(?, ?)";
        $password = password_hash($password, PASSWORD_ARGON2ID);

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);

            if (mysqli_stmt_execute($stmt))
                return true;
        }

        return false;
    }
}
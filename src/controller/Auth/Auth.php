<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");

class Auth
{
    public static function validate_creds($username, $password)
    {
        // TODO: Muss noch fertig gestellt werden
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT username, password FROM users WHERE username=? AND password=?";
        $password = password_hash($password, PASSWORD_ARGON2ID);

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            $result = mysqli_stmt_get_result($stmt);

            printf("COUNT: %s", $result->field_count);

            return true;
        }

        return false;
    }

    // Sollte funktionieren, müssen nur noch die Exceptions catchen und eine Message anzeigen
    public static function register_account($username, $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO users (username, password) VALUES(?, ?)";
        $password = password_hash($password, PASSWORD_ARGON2ID);

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);

            return true;
        }

        return false;
    }
}
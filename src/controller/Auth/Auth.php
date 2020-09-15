<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");

class Auth
{
    public static function validate_creds($username, $password)
    {
        // TODO: Passwort aus Query holen und vergleichen mit User Input
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT password FROM users WHERE username=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $username);
            $result = mysqli_stmt_get_result($stmt);
            $hash = null; // <- here

            if (password_verify($password, $hash))
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
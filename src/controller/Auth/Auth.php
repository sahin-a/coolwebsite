<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");

class Auth
{
    /**
     * starts the session and checks if both the SESSION and the Session Variable 'loggedIn' don't equal null and
     * are set.
     * @return bool
     */
    public static function isLoggedIn()
    {
        session_start();

        if (isset($_SESSION) && isset($_SESSION["loggedIn"]))
            return true;

        return false;
    }

    /**
     * checks if the user exists and then compares the saved hash from the table with the one taken from the password
     * that the user entered.
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function validate_credentials(string $username, string $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT password FROM users WHERE BINARY username=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $storedHash = $row["password"];

                if (isset($storedHash) && password_verify($password, $storedHash))
                    return true;
            }
        }

        return false;
    }

    /**
     * adds salt to the password, hashes it and then tries to insert the username and hash into the table.
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function register_account(string $username, string $password)
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
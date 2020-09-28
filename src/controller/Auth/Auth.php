<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/DatabaseCollection/DatabaseCollector.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/model/UserModel/User.php");

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

    public static function validate_credentials(string $username, string $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT id, username, password FROM users WHERE BINARY username=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $uid = $row["id"];
                $username = $row["username"];
                $storedHash = $row["password"];

                if (isset($storedHash) && isset($username) && password_verify($password, $storedHash)) {
                    $_SESSION["user"] = array("uid" => $uid, "username" => $username);

                    return true;
                }
            }
        }

        return false;
    }

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
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
        $query = "SELECT password, user FROM users WHERE BINARY username=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $storedHash = $row["password"];
                $user = $row["user"];

                if (isset($storedHash) && isset($user) && password_verify($password, $storedHash)) {
                    $_SESSION["user"] = json_decode($user, true);

                    return true;
                }
            }
        }

        return false;
    }

    public static function register_account(string $username, string $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO users (username, password, user) VALUES(?, ?, ?)";
        $password = password_hash($password, PASSWORD_ARGON2ID);

        $user = new User();
        $user->username = $username;
        $user->profile = new Profile();
        $user->role = new Role("User");

        $user = json_encode($user);

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $password, $user);

            if (mysqli_stmt_execute($stmt))
                return true;
        }

        return false;
    }
}
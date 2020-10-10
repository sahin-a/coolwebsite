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

    // TODO: alles auf die neue Methode umschreiben in DatabaseCollector.php um redundant code zu minimieren

    public static function update_password(string $username, string $curPassword, string $newPassword)
    {
        if (isset($username) && isset($curPassword) && isset($newPassword)) {
            $query = "SELECT password FROM users WHERE username=?";
            $row = (DatabaseCollector::execute_sql_query($query, "s", true, $username))[0];
            $oldPassword = $row["password"];

            if (isset($oldPassword) && password_verify($curPassword, $oldPassword)) {
                $query = "UPDATE users SET password=? WHERE username=? AND BINARY password=?";
                $curPassword = $oldPassword;
                $newPassword = password_hash($newPassword, PASSWORD_ARGON2ID);

                $result = DatabaseCollector::execute_sql_query($query, "sss", false, $newPassword, $username,
                    $curPassword);

                if ($result)
                    return true;
            }
        }

        return false;
    }

    public static function validate_credentials(string $username, string $password)
    {
        if (isset($username) && isset($password)) {
            $query = "SELECT id, username, password FROM users WHERE username=?";

            $row = (DatabaseCollector::execute_sql_query($query, "s", true, $username))[0];
            $uid = $row["id"];
            $username = $row["username"];
            $storedHash = $row["password"];

            if (isset($storedHash) && password_verify($password, $storedHash)) {
                $_SESSION["user"] = array("uid" => $uid, "username" => $username);

                return true;
            }
        }

        return false;
    }

    public static function validate_invite(string $inviteCode)
    {
        $query = "SELECT invite_code FROM invites WHERE invite_code=?";
        $result = DatabaseCollector::execute_sql_query($query, "s", false, $inviteCode);

        if ($result)
            return true;

        return false;
    }

    public static function generate_invite(int $uid)
    {
        $query = "INSERT INTO invites (uid, invite_code) VALUES(?, ?)";

        $inviteCode = "";
        try {
            $inviteCode = hash("md5", random_bytes(20));
        } catch (Exception $e) {
            return false;
        }

        $result = DatabaseCollector::execute_sql_query($query, "is", false, $uid, $inviteCode);

        if ($result)
            return true;

        return false;
    }

    public static function delete_invite(string $inviteCode)
    {
        $query = "UPDATE invites SET is_used=1 WHERE invite_code=?";
        $result = DatabaseCollector::execute_sql_query($query, "s", false, $inviteCode);

        if ($result)
            return true;

        return false;
    }

    public static function register_account(string $username, string $password, string $inviteCode)
    {
        $query = "INSERT INTO users (username, password) VALUES(?, ?)";
        $password = password_hash($password, PASSWORD_ARGON2ID);
        $result = DatabaseCollector::execute_sql_query($query, "ss", false, $username, $password);

        if ($result)
            if (self::delete_invite($inviteCode))
                return true;

        return false;
    }
}
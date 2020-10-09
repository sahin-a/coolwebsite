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
            $con = DatabaseCollector::getInstance()->getConnection();
            $query = "SELECT password FROM users WHERE username=?";

            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $username);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $oldPassword = $row["password"];

                    if (isset($oldPassword) && password_verify($curPassword, $oldPassword)) {
                        $query = "UPDATE users SET password=? WHERE username=? AND BINARY password=?";

                        $curPassword = $oldPassword;
                        $newPassword = password_hash($newPassword, PASSWORD_ARGON2ID);

                        if ($stmt = mysqli_prepare($con, $query)) {
                            mysqli_stmt_bind_param($stmt, "sss", $newPassword, $username, $curPassword);

                            if ($stmt->execute())
                                return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    public static function validate_credentials(string $username, string $password)
    {
        if (isset($username) && isset($password)) {
            $con = DatabaseCollector::getInstance()->getConnection();
            $query = "SELECT id, username, password FROM users WHERE username=?";

            if ($stmt = mysqli_prepare($con, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $username);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    $uid = $row["id"];
                    $username = $row["username"];
                    $storedHash = $row["password"];

                    if (isset($storedHash) && password_verify($password, $storedHash)) {
                        $_SESSION["user"] = array("uid" => $uid, "username" => $username);

                        return true;
                    }
                }
            }
        }

        return false;
    }

    public static function validate_invite(string $inviteCode)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "SELECT invite_code FROM invites WHERE invite_code=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $inviteCode);

            if (mysqli_stmt_execute($stmt)) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    public static function generate_invite(int $uid)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO invites (uid, invite_code) VALUES(?, ?)";

        if ($stmt = mysqli_prepare($con, $query)) {
            $inviteCode = "";
            try {
                $inviteCode = hash("md5", random_bytes(20));
            } catch (Exception $e) {
                return false;
            }

            mysqli_stmt_bind_param($stmt, "is", $uid, $inviteCode);

            if (mysqli_stmt_execute($stmt))
                return true;
        }

        return false;
    }

    public static function delete_invite(string $inviteCode)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "DELETE FROM invites WHERE BINARY invite_code=?";

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "s", $inviteCode);

            if (mysqli_stmt_execute($stmt))
                return true;
        }

        return false;
    }

    public static function register_account(string $username, string $password, string $inviteCode)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        $query = "INSERT INTO users (username, password) VALUES(?, ?)";
        $password = password_hash($password, PASSWORD_ARGON2ID);

        if ($stmt = mysqli_prepare($con, $query)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);

            if (mysqli_stmt_execute($stmt))
                if (self::delete_invite($inviteCode))
                    return true;
        }

        return false;
    }
}
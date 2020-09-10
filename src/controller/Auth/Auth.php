<?php


class Auth
{
    // TODO: schauen ob die Kagge hier überhaupt funktioniert, ist noch pseudo shit
    public static function validate_creds($username, $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();

        if ($stmt = $con->prepare("SELECT password FROM users WHERE username=?")) {
            $stmt->bind_param(1, $username);
            $result = $stmt->execute();
            $hash = $result[0];

            printf("%s", $result);

            if (password_verify($password, $hash)) {
                $stmt->close();

                return true;
            }
        }

        return false;
    }

    public static function register_account($username, $password)
    {
        $con = DatabaseCollector::getInstance()->getConnection();
        if ($stmt = $con->prepare("SELECT * FROM users WHERE username=?")) {
            $stmt->bind_param(1, $username);
            $result = $stmt.execute();
            printf("%s", $result);
        }
    }
}
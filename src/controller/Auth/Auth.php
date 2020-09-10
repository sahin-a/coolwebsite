<?php


class Auth
{
    public static function validate_creds($username, $password)
    {
        // TODO: schauen ob die Kagge hier überhaupt funktioniert
        $con = DatabaseCollector::getInstance()->getConnection();
        if ($stmt = $con->prepare("SELECT password FROM users WHERE username=?")) {
            $stmt->bind_param(1, $username);
            $result = $stmt->execute();
            $hash = $result[0];

            printf("%s", $hash);

            if (password_verify($password, $hash)) {
                $stmt->close();

                return true;
            }
        }

        return false;
    }
}
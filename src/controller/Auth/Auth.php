<?php


class Auth
{
    public static function validate_creds($username, $password)
    {
        // TODO: schauen ob die Kagge hier überhaupt funktioniert
        $con = DatabaseCollector::getInstance()->getConnection();
        $stmt = $con->prepare("SELECT password FROM users WHERE username=?");
        $stmt->bind_param(1, $username);
        $result = $stmt->execute();
        $hash = $result[0];

        printf("%s", $hash);

        if (password_verify($password, $hash))
            return true;

        return false;
    }
}
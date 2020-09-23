<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/enums/AlertType.php");

class AlertBuilder
{
    /**
     * returns a string containing the html element needed to display the required alert
     * @param $alertType int use the provided Enum AlertType
     * @param $msg
     * @return string
     */
    public static function buildAlert(int $alertType, string $msg)
    {
        $alert = "";

        switch ($alertType) {
            case AlertType::SUCCESS:
                $alert = "success";
                break;
            case AlertType::DANGER:
                $alert = "danger";
                break;
            case AlertType::WARNING:
                $alert = "warning";
                break;
        }

        return "<div class='alert alert-$alert' role='alert'>$msg</div>";
    }
}
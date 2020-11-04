<?php


class ExpiredTokenException extends Exception
{
    public function __construct() {
        parent::__construct("Expired Payload", 0, null);
    }
}
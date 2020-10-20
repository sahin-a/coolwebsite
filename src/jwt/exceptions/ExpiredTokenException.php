<?php


class ExpiredTokenException extends Exception
{
    public function __construct() {
        parent::__construct("Expired Token", 0, null);
    }
}
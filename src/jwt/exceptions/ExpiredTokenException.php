<?php


class ExpiredTokenException extends Exception
{
    public function __construct() {
        parent::__construct("Token Expired", 0, null);
    }
}
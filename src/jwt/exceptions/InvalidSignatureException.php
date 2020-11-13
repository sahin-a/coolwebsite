<?php


class InvalidSignatureException extends Exception
{
    public function __construct() {
        parent::__construct("Token Signature Invalid", 0, null);
    }
}
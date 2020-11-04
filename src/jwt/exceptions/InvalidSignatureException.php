<?php


class InvalidSignatureException extends Exception
{
    public function __construct() {
        parent::__construct("Payload Signature Invalid", 0, null);
    }
}
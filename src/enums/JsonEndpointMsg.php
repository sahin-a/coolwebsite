<?php


class JsonEndpointMsg
{
    private function __construct() {}

    public const UNAUTHORIZED = "unauthorized access";
    public const RATE_LIMITED = "rate limited";
    public const INVALID_DATA = "invalid data";
    public const INVALID_CREDENTIALS = "invalid credentials";
}
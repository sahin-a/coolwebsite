<?php


class RequestLimitType
{
    private function __construct() {}

    public const DEFAULT_MAX_REQUESTS = 50;
    public const MAX_TOKEN_REQUESTS = 10;
}
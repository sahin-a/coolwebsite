<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/ratelimiter/utils/Utils.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/ratelimiter/enums/RequestLimitType.php");

class RateLimiter
{
    private ?int $uid;
    private ?string $endpoint;

    public function __construct(int $uid)
    {
        $this->uid = $uid;
        $this->endpoint = Utils::getRequestLocation();
    }

    /**
     * @param $requestLimitType : Check RequestLimitType Class for const
     * @return bool
     */
    public function isRateLimited($requestLimitType): bool
    {
        if ($this->registerRequest()) {
            // get count of entries younger than 1 hour
            $query = "SELECT COUNT(*) FROM rate_limiter WHERE uid=? AND request_date >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
            $types = "i";

            // TODO: create a system that clears entries older than 2 hours for all users automatically
            $count = DatabaseCollector::execute_sql_query($query, $types, true, $this->uid)[0];

            if ($count >= RequestLimitType::DEFAULT_MAX_REQUESTS)
                return true;
        }

        return false;
    }

    public function registerRequest(): bool
    {
        $query = "INSERT INTO rate_limiter (uid, endpoint) VALUES(?, ?)";
        $types = "is";

        if (DatabaseCollector::execute_sql_query($query, $types, false, $this->uid, $this->endpoint))
            return true;

        return false;
    }
}
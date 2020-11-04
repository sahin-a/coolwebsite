<?php


class Payload
{
    private int $uid;
    private string $username;
    private int $iat;
    private int $expiresIn;
    private int $exp;

    private function __construct()
    {
    }

    public static function createInstance($uid, $username, $iat, $expiresIn) : self
    {
        $payload = new self;
        $payload->setUid($uid);
        $payload->setUsername($username);
        $payload->setIat($iat);
        $payload->setExpiresIn($expiresIn);
        $payload->setExp($payload->getIat() + $payload->getExpiresIn());

        return $payload;
    }

    public static function createValidPayload(int $uid, string $username, int $expiresIn = 3600) : self
    {
        $payload = new self;
        $payload->setUid($uid);
        $payload->setUsername($username);
        $payload->setIat(time());
        $payload->setExpiresIn($expiresIn);
        $payload->setExp($payload->getIat() + $payload->getExpiresIn());

        return $payload;
    }

    /**
     * @return int|null
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    private function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @param int $uid
     */
    private function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    private function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return int|null
     */
    public function getIat(): ?int
    {
        return $this->iat;
    }

    /**
     * @param int $iat
     */
    private function setIat(int $iat): void
    {
        $this->iat = $iat;
    }

    /**
     * @return int
     */
    public function getExp(): ?int
    {
        return $this->exp;
    }

    /**
     * @param int $exp
     */
    private function setExp(int $exp): void
    {
        $this->exp = $exp;
    }
}
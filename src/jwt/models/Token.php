<?php


class Token
{
    private ?int $uid;
    private ?string $username;
    private ?int $iat;
    private ?int $exp;
    private ?int $expiresIn;

    public function __construct()
    {
        $this->iat = time();
        $this->setExpiresIn(3600);
    }

    /**
     * @return int|null
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int|null $expiresIn
     */
    public function setExpiresIn(int $expiresIn): void
    {
        $this->exp = $this->iat + $expiresIn;
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
     * @param int|null $uid
     */
    public function setUid(int $uid): void
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
     * @param string|null $username
     */
    public function setUsername(string $username): void
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
     * @param int|null $iat
     */
    private function setIat(int $iat): void
    {
        $this->iat = $iat;
    }

    /**
     * @return int|null
     */
    public function getExp(): ?int
    {
        return $this->exp;
    }

    /**
     * @param int|null $exp
     */
    private function setExp(int $exp): void
    {
        $this->exp = $exp;
    }
}
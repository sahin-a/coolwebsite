<?php


class Token
{
    private ?int $uid;
    private ?string $username;
    private ?int $iat;
    private ?int $exp;
    private ?int $expiresIn;

    private function __construct()
    {
    }

    public static function is_expired(int $exp)
    {
        return time() > $exp; // exp = time() + expiresIn
    }

    public static function createValidToken(string $uid, string $username) : Token
    {
        $token = new self;
        $token->setUsername($username);
        $token->setUid($uid);
        $token->setIat(time());
        $token->setExpiresIn(3600);
        $token->setExp($token->getIat() + $token->getExpiresIn());

        return $token;
    }

    public static function createToken(int $uid, string $username, int $iat, int $exp, int $expiresIn): Token
    {
        $token = new Token(false);
        $token->setUid($uid);
        $token->setUsername($username);
        $token->setIat($iat);
        $token->setExp($exp);
        $token->setExpiresIn($expiresIn);

        return $token;
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
     * @param int|null $uid
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
     * @param string|null $username
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
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/token/Header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/token/Payload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/Secret.php");

class Token
{
    private Header $header;
    private Payload $payload;

    private function __construct()
    {
    }

    public function is_expired() : bool
    {
        return time() > $this->payload->getExp(); // exp = time() + expiresIn
    }

    public static function createValidToken(string $uid, string $username): Token
    {
        $header = Header::createDefaultHeader();
        $payload = Payload::createValidPayload($uid, $username);

        $token = new self;
        $token->setHeader($header);
        $token->setPayload($payload);

        return $token;
    }

    public static function tokenToJwt(Token $token) : string
    {
        $builder = new JWTBuilder($token);

        return $builder->build(Secret::getSecret());
    }

    public static function jwtToToken(string $bearerToken): self
    {
        $bearerToken = explode(".", $bearerToken);
        $header = $bearerToken[0];
        $payload = $bearerToken[1];

        $headerArr = json_decode(JWTUtils::base64url_decode($header));
        $payloadArr = json_decode(JWTUtils::base64url_decode($payload));

        $header = Header::createInstance(
            $headerArr["alg"],
            $headerArr["typ"]
        );

        $payload = Payload::createInstance(
            $payloadArr["uid"],
            $payloadArr["username"],
            $payloadArr["iat"],
            ($payloadArr["exp"] - $payloadArr["iat"])
        );

        $token = new self;
        $token->setHeader($header);
        $token->setPayload($payload);

        return $token;
    }

    /**
     * @return Header
     */
    public function getHeader(): Header
    {
        return $this->header;
    }

    /**
     * @param Header $header
     */
    public function setHeader(Header $header): void
    {
        $this->header = $header;
    }

    /**
     * @return Payload
     */
    public function getPayload(): Payload
    {
        return $this->payload;
    }

    /**
     * @param Payload $payload
     */
    public function setPayload(Payload $payload): void
    {
        $this->payload = $payload;
    }
}
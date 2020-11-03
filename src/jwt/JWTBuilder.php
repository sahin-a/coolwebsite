<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/Token.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");

class JWTBuilder
{
    private ?Token $token = null;

    /**
     * JWTBuilder constructor.
     * @param Token $token
     */
    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    private function createHeader(): string
    {
        return json_encode(array("alg" => "HS256", "typ" => "JWT"));
    }

    private function createPayload(): string
    {
        return json_encode(array("uid" => $this->token->getUid(), "username" => $this->token->getUsername(),
            "iat" => $this->token->getIat(), "exp" => $this->token->getExp()));
    }

    /**
     * converts the Token Object to the encoded JWT Token
     * @param string $secret
     * @return string
     */
    public function build(string $secret): string
    {
        $header = $this->createHeader();
        $payload = $this->createPayload();

        $header = JWTUtils::base64url_encode($header);
        $payload = JWTUtils::base64url_encode($payload);

        $signature = hash_hmac("sha256", $header . "." . $payload, $secret);

        return $header . "." . $payload . "." . $signature;
    }
}
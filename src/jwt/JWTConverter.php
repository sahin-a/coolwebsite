<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/models/token/Payload.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/utils/JWTUtils.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/jwt/enums/JWTAlgs.php");

class JWTConverter
{
    private Token $token;
    private Header $header;
    private Payload $payload;

    public function __construct(Token $token)
    {
        $this->token = $token;
        $this->header = $token->getHeader();
        $this->payload = $token->getPayload();
    }

    private function convertHeader(): string
    {
        return json_encode(array(
                "alg" => $this->token->getHeader()->getAlg(),
                "typ" => $this->token->getHeader()->getTyp())
        );
    }

    private function convertPayload(): string
    {
        return json_encode(array(
                "uid" => $this->payload->getUid(),
                "username" => $this->payload->getUsername(),
                "iat" => $this->payload->getIat(),
                "exp" => $this->payload->getExp())
        );
    }

    /**
     * converts the Payload Object to the encoded JWT Payload
     * @param string $secret
     * @return string
     */
    public function build(string $secret): string
    {
        $header = $this->convertHeader();
        $payload = $this->convertPayload();

        $header = JWTUtils::base64url_encode($header);
        $payload = JWTUtils::base64url_encode($payload);

        $signature = hash_hmac(JWTAlgs::parseAlgo($this->header->getAlg()),
            $header . "." . $payload, $secret);

        return $header . "." . $payload . "." . $signature;
    }
}
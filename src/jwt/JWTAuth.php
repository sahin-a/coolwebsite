<?php


class JWTAuth
{
    /**
     *
     * @param string $bearerToken the encoded jwt token
     * @param string $secret secret needed to verify the signature header
     * @return bool
     */
    public static function validate_token(string $bearerToken, string $secret): bool
    {
        $bearerToken = explode(".", $bearerToken);
        $header = $bearerToken[0];
        $payload = $bearerToken[1];
        $signature = $bearerToken[2];

        $newSignature = hash_hmac(JWTAlgs::parseAlgo(JWTAlgs::HS256), $header . "." . $payload, $secret);

        // if the hash generated with the secret from the server differs from the one that's
        // currently attached to the token, then it's invalid
        if (strcmp($signature, $newSignature) === 0)
            return true;

        return false;
    }
}
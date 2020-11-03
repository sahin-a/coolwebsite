<?php


class JWTAuth
{
    /**
     *
     * @param string $bearerToken the encoded jwt token
     * @param string $secret secret needed to verify the signature header
     * @return array|null returns payload as associative array on success
     */
    public static function validate_token(string $bearerToken, string $secret): ?array
    {
        $bearerToken = explode(".", $bearerToken);
        $header = $bearerToken[0];
        $payload = $bearerToken[1];
        $signature = $bearerToken[2];

        $newSignature = hash_hmac("sha256", $header . "." . $payload, $secret);

        if (strcmp($signature, $newSignature) === 0) {
            $payload = json_decode(JWTUtils::base64url_decode($payload), true);

            if ($payload)
                return $payload;
        }

        return null;
    }
}
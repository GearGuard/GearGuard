<?php

namespace app\utilities;

class JWTGenerator
{
    private static function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private static function base64UrlDecode($data)
    {
        $difference = strlen($data) % 4;
        if ($difference > 0) {
            $data .= str_repeat('=', 4 - $difference);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }

    public static function generateJWT($payload, $secret)
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $header = self::base64UrlEncode($header);

        $payload = json_encode($payload);
        $payload = self::base64UrlEncode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $signature = self::base64UrlEncode($signature);

        return "$header.$payload.$signature";
    }

    public static function generatePayloadForJWT(int $user_id, int $validity_period = 3600)
    {
        return [
            'exp' => time() + $validity_period,
            'uid' => $user_id,
        ];
    }

    public static function decodeJWT(string $jwt, $secret)
    {
        list($header, $payload, $signature) = explode('.', $jwt);

        $expectedSignature = hash_hmac('sha256', "$header.$payload", $secret, true);
        $expectedSignature = self::base64UrlEncode($expectedSignature);

        if (!hash_equals($expectedSignature, $signature)) {
            return null;
        }

        $decodedPayload = self::base64UrlDecode($payload);
        return json_decode($decodedPayload, true);
    }

    public static function verifyJWT(string $jwt, $secret): int
    {
        $decodedPayload = self::decodeJWT($jwt, $secret);

        if ($decodedPayload === null) {
            return 0;
        }

        if (isset($decodedPayload['exp']) && time() > $decodedPayload['exp']) {
            return 0;
        }

        return $decodedPayload['uid'] ?? 0;
    }

}
<?php

namespace Core\Auth;

class JwtManager
{
    protected string $secret;

    public function __construct(?string $secret = null)
    {
        $this->secret = $secret ?: env('JWT_SECRET', 'antigravity_default_secure_jwt_secret_key_2026');
    }

    /**
     * Generate a signed JWT token using HMAC SHA-256.
     *
     * @param array $payload
     * @param int $ttlSeconds (Default: 24 hours)
     * @return string
     */
    public function encode(array $payload, int $ttlSeconds = 86400): string
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
        ];

        $now = time();
        $payload['iat'] = $now;
        $payload['exp'] = $now + $ttlSeconds;

        $base64UrlHeader = $this->base64UrlEncode(json_encode($header));
        $base64UrlPayload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    /**
     * Decode and verify a JWT token. Returns payload array if valid, null otherwise.
     *
     * @param string $token
     * @return array|null
     */
    public function decode(string $token): ?array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            return null;
        }

        [$base64UrlHeader, $base64UrlPayload, $base64UrlSignature] = $parts;

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $expectedSignature = $this->base64UrlEncode($signature);

        if (!hash_equals($expectedSignature, $base64UrlSignature)) {
            return null; // Invalid signature
        }

        $payload = json_decode($this->base64UrlDecode($base64UrlPayload), true);

        if (!is_array($payload) || !isset($payload['exp'])) {
            return null;
        }

        if (time() > $payload['exp']) {
            return null; // Expired token
        }

        return $payload;
    }

    /**
     * Generate a cryptographic random Remember Token.
     */
    public function generateRememberToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Generate device identifier hash for client IP and User-Agent.
     */
    public function getDeviceIdentifier(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown_agent';

        return md5($ip . '|' . $ua);
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    protected function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', (4 - strlen($data) % 4) % 4));
    }
}

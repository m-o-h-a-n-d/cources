<?php

namespace App\Http\Middleware;

use Core\MiddlewareInterface;
use Core\Auth\JwtManager;
use App\Model\UserToken;

class JwtAuthMiddleware implements MiddlewareInterface
{
    public function handle()
    {
        $jwtManager = new JwtManager();
        $token = $this->extractToken();

        if (!$token) {
            $this->unauthorized("غير مصرح: يرجى تسجيل الدخول وإرفاق الـ JWT Token.");
        }

        $payload = $jwtManager->decode($token);

        if (!$payload || empty($payload['sub']) || empty($payload['role'])) {
            $this->unauthorized("رمز التوثيق (JWT Token) غير صالح أو انتهت صلاحيته.");
        }

        $userId = (int) $payload['sub'];
        $userRole = (string) $payload['role'];

        // Enforce Single Active Device Constraint against DB
        $activeTokenRecord = UserToken::findActiveToken($userId, $userRole);

        if (!$activeTokenRecord) {
            $this->unauthorized("تم إلغاء الجلسة أو انتهت صلاحيتها.");
        }

        $currentDevice = $jwtManager->getDeviceIdentifier();

        // Check if token or device matches the active device session
        if ($activeTokenRecord['device_identifier'] !== $currentDevice || $activeTokenRecord['jwt_token'] !== $token) {
            $this->unauthorized(
                "عذراً، هذا الحساب نشط حالياً على جهاز آخر. لا يُسمح إلا بجهاز واحد فقط في نفس الوقت. يرجى تسجيل الخروج من الجهاز الآخر أولاً.",
                401,
                'device_conflict'
            );
        }

        // Store authenticated identity
        $_SESSION['auth'] = [
            'id' => $userId,
            'email' => $payload['email'] ?? '',
            'role' => $userRole,
        ];
    }

    protected function extractToken(): ?string
    {
        // 1. Check Authorization: Bearer <token>
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
            return $matches[1];
        }

        // 2. Check Cookie
        if (!empty($_COOKIE['jwt_token'])) {
            return $_COOKIE['jwt_token'];
        }

        // 3. Check Query / Post
        return $_REQUEST['token'] ?? null;
    }

    protected function unauthorized(string $message, int $code = 401, string $errorType = 'unauthorized'): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode([
            'status' => false,
            'error' => $errorType,
            'message' => $message,
        ], JSON_UNESCAPED_UNICODE);

        exit;
    }
}

<?php

namespace App\Http\Controllers;

use App\Model\Student;
use App\Model\UserToken;
use App\Http\Requests\LoginRequest;
use Core\Auth\JwtManager;

class JwtAuthController
{
    protected JwtManager $jwtManager;

    public function __construct()
    {
        $this->jwtManager = new JwtManager();
    }

    public function studentLoginForm()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth']['role'] === 'student') {
            header('Location: /student');
            exit;
        }

        return view('auth/student-login');
    }

    public function adminLoginForm()
    {
        if (isset($_SESSION['auth']) && $_SESSION['auth']['role'] === 'admin') {
            header('Location: /admin');
            exit;
        }

        return view('auth/admin-login');
    }

    public function studentLogin()
    {
        $request = new LoginRequest();

        if ($request->fails()) {
            return $this->jsonResponse(false, 'بيانات غير صالحة', $request->errors(), 422);
        }

        $email = trim($request->input('email'));
        $password = trim($request->input('password'));

        $student = Student::findByEmail($email);

        if (!$student || !password_verify($password, $student['password'])) {
            return $this->jsonResponse(false, 'البريد الإلكتروني أو كلمة السر غير صحيحة.', null, 401);
        }

        $userId = (int) $student['id'];
        $userRole = 'student';
        $currentDevice = $this->jwtManager->getDeviceIdentifier();
        $now = date('Y-m-d H:i:s');

        // Strict Single Device Active Session Check: Student CANNOT login from another device unless first device logs out or session expires.
        $activeSession = UserToken::findActiveToken($userId, $userRole);

        if ($activeSession) {
            $isUnexpired = isset($activeSession['expires_at']) && $activeSession['expires_at'] > $now;
            $isDifferentDevice = $activeSession['device_identifier'] !== $currentDevice;

            if ($isUnexpired && $isDifferentDevice) {
                return $this->jsonResponse(false, 'عذراً، هذا الحساب مفتوح حالياً على جهاز آخر. يجب تسجيل الخروج من الجهاز الأول أولاً لتتمكن من الدخول من هذا الجهاز.', [
                    'device_conflict' => true,
                    'active_ip'       => $activeSession['ip_address'],
                ], 403);
            }
        }

        // Issue JWT and Remember Token
        $ttlSeconds = 86400; // 24 hours
        $jwtToken = $this->jwtManager->encode([
            'sub' => $userId,
            'email' => $student['email'],
            'role' => $userRole,
        ], $ttlSeconds);

        $rememberToken = $this->jwtManager->generateRememberToken();
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        // Save/Update Single Device Session in DB
        UserToken::saveToken([
            'user_id'           => $userId,
            'user_type'         => $userRole,
            'jwt_token'         => $jwtToken,
            'remember_token'    => $rememberToken,
            'device_identifier' => $currentDevice,
            'expires_at'        => $expiresAt,
        ]);

        setcookie('jwt_token', $jwtToken, time() + $ttlSeconds, '/', '', false, true);

        return $this->jsonResponse(true, 'تم تسجيل الدخول بنجاح', [
            'access_token'   => $jwtToken,
            'remember_token' => $rememberToken,
            'token_type'     => 'Bearer',
            'expires_in'     => $ttlSeconds,
            'user'           => [
                'id'    => $userId,
                'email' => $student['email'],
                'role'  => $userRole,
            ]
        ]);
    }

    public function adminLogin()
    {
        $request = new LoginRequest();

        if ($request->fails()) {
            return $this->jsonResponse(false, 'بيانات غير صالحة', $request->errors(), 422);
        }

        $email = trim($request->input('email'));
        $password = trim($request->input('password'));

        $admin = require base_path('config/admin.php');

        if ($email !== $admin['email'] || !password_verify($password, $admin['password'])) {
            return $this->jsonResponse(false, 'بيانات أدمن غير صحيحة.', null, 401);
        }

        $userId = 1; // Primary Admin ID
        $userRole = 'admin';
        $currentDevice = $this->jwtManager->getDeviceIdentifier();
        $now = date('Y-m-d H:i:s');

        // Strict Single Device Active Session Check
        $activeSession = UserToken::findActiveToken($userId, $userRole);

        if ($activeSession) {
            $isUnexpired = isset($activeSession['expires_at']) && $activeSession['expires_at'] > $now;
            $isDifferentDevice = $activeSession['device_identifier'] !== $currentDevice;

            if ($isUnexpired && $isDifferentDevice) {
                return $this->jsonResponse(false, 'عذراً، حساب الأدمن مفتوح حالياً على جهاز آخر. يجب تسجيل الخروج من الجهاز الأول أولاً لتتمكن من الدخول من هذا الجهاز.', [
                    'device_conflict' => true,
                    'active_ip'       => $activeSession['ip_address'],
                ], 403);
            }
        }

        $ttlSeconds = 86400;
        $jwtToken = $this->jwtManager->encode([
            'sub' => $userId,
            'email' => $admin['email'],
            'role' => $userRole,
        ], $ttlSeconds);

        $rememberToken = $this->jwtManager->generateRememberToken();
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        UserToken::saveToken([
            'user_id'           => $userId,
            'user_type'         => $userRole,
            'jwt_token'         => $jwtToken,
            'remember_token'    => $rememberToken,
            'device_identifier' => $currentDevice,
            'expires_at'        => $expiresAt,
        ]);

        setcookie('jwt_token', $jwtToken, time() + $ttlSeconds, '/', '', false, true);

        return $this->jsonResponse(true, 'تم تسجيل دخول الأدمن بنجاح', [
            'access_token'   => $jwtToken,
            'remember_token' => $rememberToken,
            'token_type'     => 'Bearer',
            'expires_in'     => $ttlSeconds,
            'user'           => [
                'id'    => $userId,
                'email' => $admin['email'],
                'role'  => $userRole,
            ]
        ]);
    }

    public function logout()
    {
        $auth = $_SESSION['auth'] ?? null;

        if ($auth && isset($auth['id'], $auth['role'])) {
            UserToken::revokeToken((int)$auth['id'], (string)$auth['role']);
        }

        $_SESSION = [];
        setcookie('jwt_token', '', time() - 3600, '/');

        return $this->jsonResponse(true, 'تم تسجيل الخروج وإلغاء الجلسة بنجاح.');
    }

    protected function jsonResponse(bool $status, string $message, mixed $data = null, int $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');

        $response = [
            'status' => $status,
            'message' => $message,
        ];

        if ($data !== null) {
            $response['data'] = $data;
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

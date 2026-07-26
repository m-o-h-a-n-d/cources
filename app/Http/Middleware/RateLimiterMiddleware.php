<?php

namespace App\Http\Middleware;

use Core\MiddlewareInterface;

class RateLimiterMiddleware implements MiddlewareInterface
{
    protected int $maxAttempts;
    protected int $decaySeconds;

    public function __construct(int $maxAttempts = 60, int $decaySeconds = 60)
    {
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function handle()
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = 'rate_limit_' . md5($ip);

        $cacheDir = sys_get_temp_dir() . '/app_rate_limits';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }

        $file = $cacheDir . '/' . $key . '.json';
        $now = time();

        $data = [
            'attempts' => 0,
            'reset_at' => $now + $this->decaySeconds,
        ];

        if (file_exists($file)) {
            $content = file_get_contents($file);
            $parsed = json_decode($content, true);

            if (is_array($parsed) && isset($parsed['reset_at'])) {
                if ($now > $parsed['reset_at']) {
                    // Window expired, reset
                    $data['attempts'] = 1;
                    $data['reset_at'] = $now + $this->decaySeconds;
                } else {
                    $data = $parsed;
                    $data['attempts']++;
                }
            } else {
                $data['attempts'] = 1;
            }
        } else {
            $data['attempts'] = 1;
        }

        file_put_contents($file, json_encode($data));

        $remaining = max(0, $this->maxAttempts - $data['attempts']);
        header("X-RateLimit-Limit: {$this->maxAttempts}");
        header("X-RateLimit-Remaining: {$remaining}");

        if ($data['attempts'] > $this->maxAttempts) {
            $retryAfter = $data['reset_at'] - $now;
            header("Retry-After: {$retryAfter}");
            http_response_code(429);
            echo json_encode([
                'error' => 'Too Many Requests',
                'message' => 'Rate limit exceeded. Please try again later.',
                'retry_after_seconds' => $retryAfter,
            ]);
            exit;
        }
    }
}

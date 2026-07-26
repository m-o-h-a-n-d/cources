<?php

namespace App\Model;

use Core\Model;

class UserToken extends Model
{
    protected static string $table = 'user_tokens';

    public static function findActiveToken(int $userId, string $userType): ?array
    {
        $table = static::getTable();
        $stmt = static::$pdo->prepare("SELECT * FROM {$table} WHERE `user_id` = ? AND `user_type` = ? LIMIT 1");
        $stmt->execute([$userId, $userType]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public static function saveToken(array $data): bool
    {
        $table = static::getTable();

        $sql = "INSERT INTO {$table} (`user_id`, `user_type`, `jwt_token`, `remember_token`, `device_identifier`, `ip_address`, `user_agent`, `expires_at`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    `jwt_token` = VALUES(`jwt_token`),
                    `remember_token` = VALUES(`remember_token`),
                    `device_identifier` = VALUES(`device_identifier`),
                    `ip_address` = VALUES(`ip_address`),
                    `user_agent` = VALUES(`user_agent`),
                    `expires_at` = VALUES(`expires_at`),
                    `updated_at` = CURRENT_TIMESTAMP";

        $stmt = static::$pdo->prepare($sql);

        return $stmt->execute([
            $data['user_id'],
            $data['user_type'],
            $data['jwt_token'],
            $data['remember_token'] ?? null,
            $data['device_identifier'],
            $data['ip_address'] ?? ($_SERVER['REMOTE_ADDR'] ?? null),
            $data['user_agent'] ?? ($_SERVER['HTTP_USER_AGENT'] ?? null),
            $data['expires_at'],
        ]);
    }

    public static function revokeToken(int $userId, string $userType): bool
    {
        $table = static::getTable();
        $stmt = static::$pdo->prepare("DELETE FROM {$table} WHERE `user_id` = ? AND `user_type` = ?");

        return $stmt->execute([$userId, $userType]);
    }
}

<?php

namespace Core;

use PDO;
use InvalidArgumentException;

abstract class Model
{
    protected static PDO $pdo;
    protected static string $table;

    public static function setConnection(PDO $pdo): void
    {
        static::$pdo = $pdo;
    }

    /**
     * Sanitize table or column names to prevent SQL Injection via raw identifiers.
     */
    protected static function sanitizeIdentifier(string $identifier): string
    {
        $clean = preg_replace('/[^a-zA-Z0-9_]/', '', $identifier);

        if (empty($clean)) {
            throw new InvalidArgumentException("Invalid SQL identifier: {$identifier}");
        }

        return "`{$clean}`";
    }

    /**
     * Get the sanitized table name.
     */
    protected static function getTable(): string
    {
        return static::sanitizeIdentifier(static::$table);
    }

    public static function all(): array
    {
        $table = static::getTable();
        $stmt = static::$pdo->prepare("SELECT * FROM {$table}");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(mixed $id): mixed
    {
        $table = static::getTable();
        $stmt = static::$pdo->prepare("SELECT * FROM {$table} WHERE `id` = ?");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByEmail(string $email): mixed
    {
        $table = static::getTable();
        $stmt = static::$pdo->prepare("SELECT * FROM {$table} WHERE `email` = ?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create(array $data): bool
    {
        $table = static::getTable();

        $columns = implode(
            ', ',
            array_map(fn($col) => static::sanitizeIdentifier($col), array_keys($data))
        );

        $placeholders = implode(
            ', ',
            array_fill(0, count($data), '?')
        );

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $stmt = static::$pdo->prepare($sql);

        return $stmt->execute(array_values($data));
    }

    public static function update(array $data, mixed $id): bool
    {
        $table = static::getTable();

        $setClause = implode(
            ', ',
            array_map(fn($col) => static::sanitizeIdentifier($col) . " = ?", array_keys($data))
        );

        $sql = "UPDATE {$table} SET {$setClause} WHERE `id` = ?";

        $stmt = static::$pdo->prepare($sql);

        return $stmt->execute([...array_values($data), $id]);
    }

    public static function delete(mixed $id): bool
    {
        $table = static::getTable();

        $stmt = static::$pdo->prepare("DELETE FROM {$table} WHERE `id` = ?");

        return $stmt->execute([$id]);
    }
}
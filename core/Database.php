<?php

namespace Core;

use PDO;

class Database
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

        $this->pdo = new PDO(
            $dsn,
            $config['username'],
            $config['password']
        );
    }

    public function connection(): PDO
    {
        return $this->pdo;
    }
}
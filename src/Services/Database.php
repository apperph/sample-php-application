<?php

namespace ApperPH\SamplePHPApplication\Services;

use PDO;

class Database
{
    protected $pdo;

    public function __construct(
        string $host,
        string $port,
        string $username,
        string $password,
        string $name
    ) {
        $dsn = sprintf('mysql:dbname=%s;host=%s;port=%s', $name, $host, $port);

        $this->pdo = new PDO($dsn, $username, $password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    public static function try() {
        $db = new self(
            $_ENV['DB_HOST'] ?? null,
            $_ENV['DB_PORT'] ?? null,
            $_ENV['DB_USERNAME'] ?? null,
            $_ENV['DB_PASSWORD'] ?? null,
            $_ENV['DB_NAME'] ?? null,
        );

        return $db->testConnection();
    }

    public function testConnection() {
        $result = $this->pdo->query('SELECT 1 + 1');

        return !!$result;
    }
}

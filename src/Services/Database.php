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

    public static function connect()
    {
        $db = new self(
            $_ENV['DB_HOST'] ?? null,
            $_ENV['DB_PORT'] ?? null,
            $_ENV['DB_USERNAME'] ?? null,
            $_ENV['DB_PASSWORD'] ?? null,
            $_ENV['DB_NAME'] ?? null,
        );

        $db->createHealthcheckSimulationTable();

        return $db;
    }

    public function testConnection()
    {
        $result = $this->pdo->query('SELECT 1 + 1');

        return !!$result;
    }

    public function setSimulationResponse(string $response)
    {
        $statement = $this->pdo->prepare('
            INSERT INTO healthcheck_simulation (app, response) VALUES (:app, :response)
                ON DUPLICATE KEY UPDATE response = :response
        ');

        $statement->execute([
            'app' => $_ENV['APP_NAME'],
            'response' => $response,
        ]);
    }

    public function getSimulationResponse()
    {
        $statement = $this->pdo->prepare('
            SELECT response FROM healthcheck_simulation WHERE app = :app LIMIT 1
        ');

        $statement->execute([
            'app' => $_ENV['APP_NAME'],
        ]);

        $result = $statement->fetch();

        return $result->response;
    }

    protected function createHealthcheckSimulationTable()
    {
        $this->pdo->query('
            CREATE TABLE IF NOT EXISTS healthcheck_simulation (
                app VARCHAR(255) NOT NULL PRIMARY KEY,
                response VARCHAR(255) NOT NULL
            )
        ');
    }
}

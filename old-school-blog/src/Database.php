<?php

declare(strict_types=1);

namespace Experiments\Blog;

use PDO;

final class Database
{
    private static self $instance;
    private ?PDO $pdo = null;

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $config = require __DIR__ . '/../config.php';
        $this->pdo = new PDO($config['db']['path']);
    }

    public function query(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($column) => ":$column", array_keys($data)));
        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";

        $statement = $this->pdo->prepare($query);
        $statement->execute($data);

        return (int)$this->pdo->lastInsertId();
    }

    public function __destruct()
    {
        // close connection
        $this->pdo = null;
    }
}
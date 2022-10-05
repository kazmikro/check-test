<?php

namespace App;

use App\Contracts\DatabaseInterface;
use PDO;

/**
 * Simple database PDO wrapper
 */
class Database implements DatabaseInterface
{
    private object $connection;

    public function __construct(string $host, string $dbName, string $user, string $password, string $charset)
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbName . ';charset=' . $charset;
        $this->connection = new PDO($dsn, $user, $password, $options);
    }

    public function fetch(string $query, array $parameters = []): ?object
    {
        $prepared_query = $this->connection->prepare($query);
        $prepared_query->execute($parameters);
        $result = $prepared_query->fetch();
        return $result === false ? null : $result;
    }

    public function fetchAll(string $query, array $parameters = []): array
    {
        $prepared_query = $this->connection->prepare($query);
        $prepared_query->execute($parameters);
        return $prepared_query->fetchAll();
    }

    public function execute(string $query, array $parameters = []): bool
    {
        $prepared_query = $this->connection->prepare($query);
        return $prepared_query->execute($parameters);
    }
}

<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\PDO;

use PDO;
use Thiiagoms\Bugtracking\Database\QueryBuilder;

class PDOQueryBuilder extends QueryBuilder
{
    public function get(): mixed
    {
        return $this->statement->fetchAll();
    }

    public function count(): int
    {
        return $this->statement->rowCount();
    }

    public function lastInsertId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    public function prepare(string $query): mixed
    {
        return $this->connection->prepare($query);
    }

    public function execute($statement)
    {
        $statement->execute($this->bindings);
        $this->bindings = [];
        $this->placeholders = [];

        return $statement;
    }

    public function fetchInto($className): mixed
    {
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function affected(): int
    {
        return $this->count();
    }
}

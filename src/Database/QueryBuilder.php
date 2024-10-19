<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database;

use mysqli;
use mysqli_stmt;
use PDO;
use PDOStatement;
use stdClass;
use Thiiagoms\Bugtracking\Contracts\Database\DatabaseConnectionContract;
use Thiiagoms\Bugtracking\Enums\DatabaseDMLEnum;
use Thiiagoms\Bugtracking\Enums\QueryOperatorEnum;
use Thiiagoms\Bugtracking\Exceptions\InvalidArgumentException;
use Thiiagoms\Bugtracking\Traits\Database\QueryTrait;

abstract class QueryBuilder
{
    use QueryTrait;

    protected PDO|mysqli $connection;
    protected string $table;
    protected PDOStatement|mysqli_stmt $statement;

    protected array|string $fields;
    protected array $placeholders;
    protected array $bindings;

    protected string $operation = DatabaseDMLEnum::DML_TYPE_SELECT->value;

    protected const string PLACEHOLDER = '?';
    protected const string COLUMNS = '*';

    public function __construct(DatabaseConnectionContract $databaseConnection)
    {
        $this->connection = $databaseConnection->getConnection();
    }

    public function table(string $table): QueryBuilder
    {
        $this->table = $table;

        return $this;
    }

    private function parseWhere(array $conditions, string $operator): QueryBuilder
    {
        foreach ($conditions as $column => $value) {
            $this->placeholders[] = sprintf('%s %s %s', $column, $operator, self::PLACEHOLDER);
            $this->bindings[] = $value;
        }

        return $this;
    }

    public function where(string $column, string $operator = '=', mixed $value = null): QueryBuilder
    {
        if (! QueryOperatorEnum::tryFrom($operator)) {
            throw new InvalidArgumentException('Operator is not valid', ['operator' => $operator]);
        }

        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->parseWhere([$column => $value], $operator);

        return $this;
    }

    public function select(string $fields = self::COLUMNS): QueryBuilder
    {
        $this->operation = DatabaseDMLEnum::DML_TYPE_SELECT->value;
        $this->fields = $fields;

        return $this;
    }

    public function create(array $data): int
    {
        $this->fields = '`' . implode('`, `', array_keys($data)) . '`';

        foreach ($data as $value) {
            $this->placeholders[] = self::PLACEHOLDER;
            $this->bindings[] = $value;
        }

        $query = $this->prepare($this->getQuery(DatabaseDMLEnum::DML_TYPE_INSERT));
        $this->statement = $this->execute($query);

        return $this->lastInsertId();
    }

    public function update(array $data): QueryBuilder
    {
        $this->fields = [];

        $this->operation = DatabaseDMLEnum::DML_TYPE_UPDATE->value;

        foreach ($data as $column => $value) {
            $this->fields[] = sprintf('%s%s%s', $column, QueryOperatorEnum::EQUALS->value, "'{$value}'");
        }

        return $this;
    }

    public function delete(): QueryBuilder
    {
        $this->operation = DatabaseDMLEnum::DML_TYPE_DELETE->value;

        return $this;
    }

    public function raw(string $query): QueryBuilder
    {
        $query = $this->prepare($query);

        $this->statement = $this->execute($query);

        return $this;
    }

    public function runQuery(): QueryBuilder
    {
        $operation = DatabaseDMLEnum::from($this->operation);

        $query = $this->prepare($this->getQuery($operation));

        $this->statement = $this->execute($query);

        return $this;
    }

    public function first(): mixed
    {
        return $this->count() ? $this->get()[0] : null;
    }

    public function find(int $id): mixed
    {
        $query = $this->where(column: 'id', value: $id)->runQuery();

        return $query->first();
    }

    public function findOneBy(string $field, mixed $value): QueryBuilder|stdClass
    {
        $query = $this->where(column: $field, value: $value)->runQuery();

        return $query->first();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }

    abstract public function get(): mixed;
    abstract public function count(): int|bool;
    abstract public function lastInsertId(): int;
    abstract public function prepare(string $query): mixed;
    abstract public function execute($statement);
    abstract public function fetchInto($className): mixed;
    abstract public function beginTransaction(): void;
    abstract public function affected(): int;
}

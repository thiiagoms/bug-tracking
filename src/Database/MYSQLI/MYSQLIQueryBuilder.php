<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\MYSQLI;

use Thiiagoms\Bugtracking\Database\QueryBuilder;
use Thiiagoms\Bugtracking\Exceptions\InvalidArgumentException;

class MYSQLIQueryBuilder extends QueryBuilder
{
    private object|array $resultSet = [];

    private $results;

    private const string PARAM_TYPE_INT = 'i';
    private const string PARAM_TYPE_STRING = 's';
    private const string PARAM_TYPE_DOUBLE = 'd';

    public function get(): mixed
    {
        $results = [];

        if (! $this->resultSet) {
            $this->resultSet = $this->statement->get_result();

            if ($this->resultSet) {
                while ($object = $this->resultSet->fetch_object()) {
                    $results[] = $object;
                }

                $this->results = $results;
            }
        }
        return $this->results;
    }

    public function count(): int|bool
    {
        if (!$this->resultSet) {
            $this->get();
        }
        return $this->resultSet ? $this->resultSet->num_rows : false;
    }

    public function lastInsertId(): int
    {
        return $this->connection->insert_id;
    }

    public function prepare($query): mixed
    {
        return $this->connection->prepare($query);
    }

    public function execute($statement)
    {
        if (!$statement) {
            throw new InvalidArgumentException('MySQLi statement is false');
        }

        if ($this->bindings) {
            $bindings = $this->parseBindings($this->bindings);
            $reflectionObj = new \ReflectionClass('mysqli_stmt');
            $method = $reflectionObj->getMethod('bind_param');
            $method->invokeArgs($statement, $bindings);
        }
        $statement->execute();
        $this->bindings = [];
        $this->placeholders = [];

        return $statement;
    }

    private function parseBindings(array $params)
    {
        $bindings = [];
        $count = count($params);
        if ($count === 0) {
            return $this->bindings;
        }

        $bindingTypes = $this->parseBindingTypes(); //"sids"
        $bindings[] = &$bindingTypes;
        for ($index = 0; $index < $count; $index++) {
            $bindings[] = &$params[$index];
        }
        return $bindings;
    }

    public function parseBindingTypes()
    {
        $bindingTypes = [];

        foreach ($this->bindings as $binding) {
            if (is_int($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_INT;
            }

            if (is_string($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_STRING;
            }

            if (is_float($binding)) {
                $bindingTypes[] = self::PARAM_TYPE_DOUBLE;
            }
        }
        return implode('', $bindingTypes);
    }

    public function fetchInto($className): mixed
    {
        $results = [];
        $this->resultSet = $this->statement->get_result();
        while ($object = $this->resultSet->fetch_object($className)) {
            $results[] = $object;
        }
        return $this->results = $results;
    }

    public function beginTransaction(): void
    {
        $this->connection->begin_transaction();
    }

    public function affected(): int
    {
        $this->statement->store_result();

        return $this->statement->affected_rows;
    }
}

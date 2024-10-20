<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Repositories;

use Thiiagoms\Bugtracking\Contracts\Repositories\RepositoryContract;
use Thiiagoms\Bugtracking\Database\QueryBuilder;
use Thiiagoms\Bugtracking\Entities\Entity;

abstract class Repository implements RepositoryContract
{
    protected static string $table;
    protected static string $className;

    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function findOneBy(string $field, mixed $value): ?object
    {
        $result = $this->queryBuilder
            ->table(static::$table)
            ->select()
            ->where(column: $field, value: $value)
            ->runQuery()
            ->fetchInto(static::$className);

        return $result[0] ?? null;
    }

    public function find(int $id): ?object
    {
        return $this->findOneBy('id', $id);
    }

    public function findBy(array $criteria): mixed
    {
        $this->queryBuilder->table(static::$table);

        foreach ($criteria as $criterion) {
            $this->queryBuilder->where(...$criterion);
        }

        return $this->queryBuilder->runQuery()->fetchInto(static::$className);
    }

    public function findAll(int $id): array
    {
        return $this->queryBuilder
            ->table(static::$table)
            ->select()
            ->where(column: 'id', value: $id)
            ->runQuery()
            ->fetchInto(static::$className);
    }

    public function withSQL(string $query): mixed
    {
        return $this->queryBuilder->raw($query)->fetchInto(static::$className);
    }

    public function create(Entity $entity): object
    {
        $id = $this->queryBuilder
            ->table(static::$table)
            ->create($entity->toArray());

        return $this->find($id);
    }

    public function update(Entity $entity, array $conditions = []): object
    {
        $this->queryBuilder
            ->table(static::$table)
            ->update($entity->toArray());

        foreach ($conditions as $condition) {
            $this->queryBuilder->where(...$condition);
        }

        $this->queryBuilder
            ->where(column: 'id', value: $entity->getId())
            ->runQuery();

        return $this->find($entity->getId());
    }

    public function delete(Entity $entity, array $conditions = []): void
    {
        $this->queryBuilder
            ->table(static::$table)
            ->delete($entity->toArray());

        foreach ($conditions as $condition) {
            $this->queryBuilder->where(...$condition);
        }
        $this->queryBuilder
            ->where(column: 'id', value: $entity->getId())
            ->runQuery();
    }
}

<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Contracts\Repositories;

use Thiiagoms\Bugtracking\Entities\Entity;

interface RepositoryContract
{
    public function find(int $id): ?object;
    public function findOneBy(string $field, mixed $value): ?object;
    public function findBy(array $criteria): mixed;
    public function findAll(int $id): array;
    public function create(Entity $entity): object;
    public function update(Entity $entity, array $conditions = []): object;
    public function delete(Entity $entity, array $conditions = []): void;
}

<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Traits\Database;

use InvalidArgumentException;
use Thiiagoms\Bugtracking\Contracts\Database\QueryContract;
use Thiiagoms\Bugtracking\Database\Query\DeleteQuery;
use Thiiagoms\Bugtracking\Database\Query\InsertQuery;
use Thiiagoms\Bugtracking\Database\Query\SelectQuery;
use Thiiagoms\Bugtracking\Database\Query\UpdateQuery;
use Thiiagoms\Bugtracking\Enums\DatabaseDMLEnum;

trait QueryTrait
{
    private function resolveQuery(DatabaseDMLEnum $type): QueryContract
    {
        return match ($type) {
            DatabaseDMLEnum::DML_TYPE_SELECT => new SelectQuery(),
            DatabaseDMLEnum::DML_TYPE_INSERT => new InsertQuery(),
            DatabaseDMLEnum::DML_TYPE_UPDATE => new UpdateQuery(),
            DatabaseDMLEnum::DML_TYPE_DELETE => new DeleteQuery(),
            default => throw new InvalidArgumentException('Invalid query type'),
        };
    }

    public function getQuery(DatabaseDMLEnum $type): string
    {
        $queryGenerator = $this->resolveQuery($type);

        return $queryGenerator->buildQuery($this->table, $this->fields, $this->placeholders);
    }
}

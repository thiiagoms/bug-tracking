<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\Query;

use Thiiagoms\Bugtracking\Contracts\Database\QueryContract;

class SelectQuery implements QueryContract
{
    public function buildQuery(string $table, string|array $fields, array $placeholders): string
    {
        return sprintf('SELECT %s FROM %s WHERE %s', $fields, $table, implode(' AND ', $placeholders));
    }
}

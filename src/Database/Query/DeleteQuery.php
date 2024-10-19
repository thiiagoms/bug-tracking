<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\Query;

use Thiiagoms\Bugtracking\Contracts\Database\QueryContract;

class DeleteQuery implements QueryContract
{
    public function buildQuery(string $table, string|array $fields, array $placeholders): string
    {
        return sprintf('DELETE FROM %s WHERE %s', $table, implode(' AND ', $placeholders));
    }
}

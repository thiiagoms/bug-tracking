<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\Query;

use Thiiagoms\Bugtracking\Contracts\Database\QueryContract;

class InsertQuery implements QueryContract
{
    public function buildQuery(string $table, string|array $fields, array $placeholders): string
    {
        return sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $fields, implode(',', $placeholders));
    }
}

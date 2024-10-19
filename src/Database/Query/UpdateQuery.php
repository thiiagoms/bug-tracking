<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\Query;

use Thiiagoms\Bugtracking\Contracts\Database\QueryContract;

class UpdateQuery implements QueryContract
{
    public function buildQuery(string $table, string|array $fields, array $placeholders): string
    {
        return sprintf('UPDATE %s SET %s WHERE %s', $table, implode(', ', $fields), implode(' AND ', $placeholders));
    }
}

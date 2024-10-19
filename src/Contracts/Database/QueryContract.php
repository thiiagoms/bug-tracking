<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Contracts\Database;

interface QueryContract
{
    public function buildQuery(string $table, string|array $fields, array $placeholders): string;
}

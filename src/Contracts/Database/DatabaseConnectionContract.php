<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Contracts\Database;

use mysqli;
use PDO;

interface DatabaseConnectionContract
{
    public function connect(): self;

    public function getConnection(): PDO|mysqli;

    public function close(): void;
}

<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Contracts\Database;

use PDO;
use Thiiagoms\Bugtracking\DAtabase\PDOConnection;

interface DatabaseConnectionContract
{
    public function connect(): PDOConnection;

    public function getConnection(): PDO;

    public function close(): void;
}

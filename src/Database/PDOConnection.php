<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database;

use PDO;
use Thiiagoms\Bugtracking\Contracts\Database\DatabaseConnectionContract;
use Thiiagoms\Bugtracking\Database\AbstractConnection;

class PDOConnection extends AbstractConnection implements DatabaseConnectionContract
{
    public function connect(): PDOConnection
    {
        return $this;
    }

    public function getConnection(): PDO
    {
        return new PDO('');
    }

    public function close(): void
    {
    }
}

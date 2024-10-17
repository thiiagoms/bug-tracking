<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database\MYSQLI;

use mysqli;
use mysqli_driver;
use Tests\Unit\Database\DatabaseConnectionTest;
use Thiiagoms\Bugtracking\Contracts\Database\DatabaseConnectionContract;
use Thiiagoms\Bugtracking\Database\AbstractConnection;

class MYSQLIConnection extends AbstractConnection implements DatabaseConnectionContract
{
    protected function parseCredentials(array $credentials): array
    {
        return [
            $credentials['host'] ,
            $credentials['db_username'],
            $credentials['db_user_password'],
            $credentials['db_name'],
        ];
    }

    public function connect(): MYSQLIConnection
    {
        $driver = new mysqli_driver();
        $driver->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

        $credentials = $this->parseCredentials($this->credentials);

        try {
            $this->connection = new mysqli(...$credentials);
        } catch (\Throwable $exception) {
            throw new DatabaseConnectionTest(
                $exception->getMessage(),
                $this->credentials,
                500
            );
        }

        return $this;
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    public function close(): void
    {
        $this->connection = null;
    }
}

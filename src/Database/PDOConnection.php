<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database;

use PDO;
use PDOException;
use Thiiagoms\Bugtracking\Contracts\Database\DatabaseConnectionContract;
use Thiiagoms\Bugtracking\Database\AbstractConnection;
use Thiiagoms\Bugtracking\Exceptions\DatabaseConnectionException;

class PDOConnection extends AbstractConnection implements DatabaseConnectionContract
{
    public function connect(): PDOConnection
    {
        $credentials = $this->parseCredentials($this->credentials);

        try {
            $this->connection = new PDO(...$credentials);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->credentials['default_fetch']);
        } catch (PDOException $exception) {
            throw new DatabaseConnectionException($exception->getMessage(), $this->credentials, 500);
        }

        return $this;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function close(): void
    {
        $this->connection = null;
    }

    protected function parseCredentials(array $credentials): array
    {
        $dsnConnection = sprintf(
            '%s:host=%s;dbname=%s',
            $credentials['driver'],
            $credentials['host'],
            $credentials['db_name']
        );

        return [$dsnConnection, $credentials['db_username'], $credentials['db_user_password']];
    }
}

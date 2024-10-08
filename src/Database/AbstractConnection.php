<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Database;

use PDO;
use Thiiagoms\Bugtracking\Exceptions\MissingArgumentsException;

abstract class AbstractConnection
{
    protected PDO $connection;

    protected const REQUIRED_CONNECTION_KEYS = [
        'driver',
        'host',
        'db_name',
        'db_username',
        'db_user_password',
        'default_fetch'
    ];

    public function __construct(private readonly array $credentials)
    {
        if (! $this->credentialsHaveRequiredKeys($this->credentials)) {
            throw new MissingArgumentsException('Database connection credentials are not mapped correctly');
        }
    }

    private function credentialsHaveRequiredKeys(array $credentials): bool
    {
        $matches = array_intersect_key(static::REQUIRED_CONNECTION_KEYS, array_keys($credentials));

        return count($matches) === count(static::REQUIRED_CONNECTION_KEYS);
    }
}

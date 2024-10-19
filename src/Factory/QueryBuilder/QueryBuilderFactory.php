<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Factory\QueryBuilder;

use Thiiagoms\Bugtracking\Database\MYSQLI\MYSQLIConnection;
use Thiiagoms\Bugtracking\Database\MYSQLI\MYSQLIQueryBuilder;
use Thiiagoms\Bugtracking\Database\PDO\PDOConnection;
use Thiiagoms\Bugtracking\Database\PDO\PDOQueryBuilder;
use Thiiagoms\Bugtracking\Database\QueryBuilder;
use Thiiagoms\Bugtracking\Exceptions\DatabaseConnectionException;
use Thiiagoms\Bugtracking\Helpers\Config;

class QueryBuilderFactory
{
    private static function generatePDOConnection(array $credentials): PDOQueryBuilder
    {
        $connection = (new PDOConnection($credentials))->connect();

        return new PDOQueryBuilder($connection);
    }

    private static function generateMYSQLIConnection(array $credentials): MYSQLIQueryBuilder
    {
        $connection = (new MYSQLIConnection($credentials))->connect();

        return new MYSQLIQueryBuilder($connection);
    }

    public static function make(
        string $config = 'database',
        string $connection = 'pdo',
        array $options = []
    ): QueryBuilder {

        $credentials = array_merge(Config::get($config, $connection), $options);

        return match ($connection) {
            'pdo'    => self::generatePDOConnection($credentials),
            'mysqli' => self::generateMYSQLIConnection($credentials),
            default  => throw new DatabaseConnectionException('Connection type is not recognize internally', [
                'type' => $connection
            ]),
        };
    }
}

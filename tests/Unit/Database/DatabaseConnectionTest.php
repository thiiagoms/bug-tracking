<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Contracts\Database\DatabaseConnectionContract;
use Thiiagoms\Bugtracking\Database\PDOConnection;
use Thiiagoms\Bugtracking\Exceptions\MissingArgumentsException;
use Thiiagoms\Bugtracking\Helpers\Config;

class DatabaseConnectionTest extends TestCase
{
    public function testItThrowMissingArgumentExceptionWithWrongCredentialKeys(): void
    {
        $this->expectException(MissingArgumentsException::class);
        $this->expectExceptionMessage('Database connection credentials are not mapped correctly');

        new PDOConnection([]);
    }

    public function testItCanConnectToDatabaseWithPdoApi(): PDOConnection
    {
        $credentials = $this->getCredentials('pdo');

        $handler = (new PDOConnection($credentials))->connect();

        $this->assertInstanceOf(DatabaseConnectionContract::class, $handler);

        return $handler;
    }

    #[Depends('testItCanConnectToDatabaseWithPdoApi')]
    public function testItIsAValidPdoConnection(DatabaseConnectionContract $handler): void
    {
        $this->assertInstanceOf(\PDO::class, $handler->getConnection());
    }

    private function getCredentials(string $type): array
    {
        return array_merge(
            Config::get('database', $type),
            ['database' => 'bug_app_testing']
        );
    }
}

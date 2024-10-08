<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Database\PDOConnection;
use Thiiagoms\Bugtracking\Exceptions\MissingArgumentsException;

class DatabaseConnectionTest extends TestCase
{
    public function testItThrowMissingARgumentExceptionWithWrongCredentialKeys(): void
    {
        $message =

        $this->expectException(MissingArgumentsException::class);
        $this->expectExceptionMessage('Database connection credentials are not mapped correctly');

        $pdoHandler = new PDOConnection([]);
    }

    public function testItCanConnectToDatabaseWithPdoApi(): void
    {
        $handler = (new PDOConnection([]))->connect();

        $this->assertNotNull($handler);
    }
}

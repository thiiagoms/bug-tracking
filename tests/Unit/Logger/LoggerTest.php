<?php

declare(strict_types=1);

namespace Tests\Unit\Logger;

use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Contracts\LoggerContract;
use Thiiagoms\Bugtracking\Exceptions\InvalidLogLevelArgumentException;
use Thiiagoms\Bugtracking\Helpers\App;
use Thiiagoms\Bugtracking\Logger\Logger;

class LoggerTest extends TestCase
{
    private Logger $logger;

    public function setUp(): void
    {
        $this->logger = new Logger();

        parent::setUp();
    }

    public function testItImplementsTheLoggerInterface(): void
    {
        $this->assertInstanceOf(LoggerContract::class, new Logger);
    }

    public function testItCandCanCreateDifferentTypesOfLogLevel(): void
    {
        $this->logger->info('Testing info logs');
        $this->logger->error('Testing error logs');
        $this->logger->log('alert', 'Testing Alert logs');

        $app = new App();

        $file =  sprintf("%s/%s-%s.log", $app->getLogPath(), 'test', date('j.n.Y'));

        $fileContent = file_get_contents($file);

        $this->assertStringContainsString('Testing info logs', $fileContent);
        $this->assertStringContainsString('Testing error logs', $fileContent);
        $this->assertStringContainsString('Testing Alert logs', $fileContent);

        unlink($file);

        $this->assertFileDoesNotExist($file);
    }

    public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLevel(): void
    {
        $this->expectException(InvalidLogLevelArgumentException::class);
        $this->expectExceptionMessage('invalid');

        $this->logger->log('invalid', 'testing invalid log level');
    }
}
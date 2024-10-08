<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Helpers\App;

class ApplicationTest extends TestCase
{
    public function testItCanGetInstanceOfApplication(): void
    {
        $this->assertInstanceOf(App::class, new App());
    }

    public function testItCanGetBasicApplicationDatasetFromAppClass(): void
    {
        $application = new App();

        $this->assertTrue($application->isRunningFromConsole());
        $this->assertSame('test', $application->getEnvironment());
        $this->assertNotNull($application->getLogPath());
        $this->assertInstanceOf(\DateTime::class, $application->getServerTime());
    }
}

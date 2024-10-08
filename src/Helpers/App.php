<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Helpers;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

class App
{
    private array $config = [];

    public function __construct()
    {
        $this->config = Config::get('app');
    }

    public function isDebugMode(): bool
    {
        if (! isset($this->config['debug'])) {
            return false;
        }

        return $this->config['debug'];
    }

    public function getEnvironment(): string
    {
        if (! isset($this->config['env'])) {
            return 'production';
        }

        return $this->isTestMode() ? 'test' : $this->config['env'];
    }

    public function getLogPath(): string
    {
        if (! isset($this->config['log_path'])) {
            throw new \Exception('Log path is not defined');
        }

        return $this->config['log_path'];
    }

    public function isRunningFromConsole(): bool
    {
        return in_array(php_sapi_name(), ['cli', 'phpdbg'], true);
    }

    public function getServerTime(): DateTimeInterface
    {
        return new DateTime('now', new DateTimeZone('America/Sao_Paulo'));
    }

    public function isTestMode(): bool
    {
        $testSuitIsRunning = defined('PHPUNIT_RUNNING');

        if ($this->isRunningFromConsole() && ($testSuitIsRunning === true)) {
            return true;
        }

        return false;
    }
}

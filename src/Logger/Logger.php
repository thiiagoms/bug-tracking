<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Logger;

use Thiiagoms\Bugtracking\Contracts\LoggerContract;
use Thiiagoms\Bugtracking\Enums\LogLevelEnum;
use Thiiagoms\Bugtracking\Exceptions\InvalidLogLevelArgumentException;
use Thiiagoms\Bugtracking\Helpers\App;

class Logger implements LoggerContract
{
    private function addRecord(LogLevelEnum $level, string $message, array $context = []): void
    {
        $app = new App();
        $date = $app->getServerTime()->format('Y-m-d H:i:s');
        $logPath = $app->getLogPath();
        $env = $app->getEnvironment();

        $details = sprintf(
            "%s - Level: %s - Message: %s - Context: %s",
            $date,
            $level->value,
            $message,
            json_encode($context, JSON_PRETTY_PRINT)
        ) . PHP_EOL;

        $fileName = sprintf("%s/%s-%s.log", $logPath, $env, date('j.n.Y'));

        file_put_contents($fileName, $details, FILE_APPEND);
    }

    public function emergency(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::EMERGENCY, $message, $data);
    }

    public function alert(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::ALERT, $message, $data);
    }

    public function critical(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::CRITICAL, $message, $data);
    }

    public function error(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::ERROR, $message, $data);
    }

    public function warning(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::WARNING, $message, $data);
    }

    public function notice(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::NOTICE, $message, $data);
    }

    public function info(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::INFO, $message, $data);
    }

    public function debug(string $message, array $data = []): void
    {
        $this->addRecord(LogLevelEnum::DEBUG, $message, $data);
    }

    private function checkLogLevelExists(string $level): void
    {
        $validLogLevels = LogLevelEnum::cases();

        $logLevelExists = (bool) array_search($level, array_column($validLogLevels, "value"), true);

        if (! $logLevelExists) {
            throw new InvalidLogLevelArgumentException($level, $validLogLevels);
        }
    }

    public function log(string $level, string $message, array $data = []): void
    {
        $this->checkLogLevelExists($level);

        $level = LogLevelEnum::from($level);

        $this->addRecord($level, $message, $data);
    }
}

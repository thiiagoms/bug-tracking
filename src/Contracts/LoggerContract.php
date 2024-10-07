<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Contracts;

interface LoggerContract
{
    public function emergency(string $message, array $data = []): void;
    public function alert(string $message, array $data = []): void;
    public function critical(string $message, array $data = []): void;
    public function error(string $message, array $data = []): void;
    public function warning(string $message, array $data = []): void;
    public function notice(string $message, array $data = []): void;
    public function info(string $message, array $data = []): void;
    public function debug(string $message, array $data = []): void;
    public function log(string $level, string $message, array $data = []): void;
}

<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Exceptions;

use ErrorException;
use Thiiagoms\Bugtracking\Helpers\App;
use Throwable;

class ExceptionHandler
{
    public function handle(Throwable $exception): void
    {
        $app = new App();

        if ($app->isDebugMode()) {
            var_dump($exception);
            return;
        }

        echo 'This should not have happened, please try again later.' . PHP_EOL;
    }

    public function convertWarningsAndNoticesToException(int $severity, string $message, string $file, int $line): void
    {
        throw new ErrorException(message: $message, code: $severity, severity: $severity, filename: $file, line: $line);
    }
}

<?php

declare(strict_types=1);

use Thiiagoms\Bugtracking\Exceptions\ExceptionHandler;

require_once __DIR__ . '/vendor/autoload.php';

set_error_handler([new ExceptionHandler(), 'convertWarningsAndNoticesToException']);
set_exception_handler([new ExceptionHandler(), 'handle']);

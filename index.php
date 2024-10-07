<?php

declare(strict_types=1);

use Thiiagoms\Bugtracking\Logger\Logger;

require_once __DIR__ . '/bootstrap.php';

$logger = new Logger();

$logger->log('emergency', 'There is an emergency');
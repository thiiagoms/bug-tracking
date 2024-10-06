<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Helpers;

use RuntimeException;
use Throwable;

class Config
{
    public static function get(string $fileName, string $key = null): array|string
    {
        $fileContent = self::getFileContent($fileName);

        if ($key === null) {
            return $fileContent;
        }

        return isset($fileContent[$key]) ? $fileContent[$key] : [];
    }

    private static function getFileContent(string $fileName): array
    {
        $fileContent = [];

        try {
            $path = realpath(sprintf(__DIR__ . '/../Configs/%s.php', $fileName));

            if (file_exists($path)) {
                $fileContent = require $path;
            }
        } catch (Throwable $exception) {
            throw new RuntimeException(
                sprintf('The specified file: %s was not found', $fileName)
            );
        }

        return $fileContent;
    }
}

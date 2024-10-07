<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Exceptions;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    protected array $data = [];

    public function __construct(string $message, array $data = [], int $code = 0, Throwable $previous = null)
    {
        $this->data = $data;

        parent::__construct($message, $code, $previous);
    }

    public function setData(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function getExtraData(): array
    {
        if (count($this->data) === 0) {
            return $this->data;
        }

        return json_decode(json_encode($this->data, JSON_PRETTY_PRINT), true);
    }
}

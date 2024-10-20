<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Entities;

abstract class Entity
{
    abstract public function getId(): int;
    abstract public function toArray(): array;
}

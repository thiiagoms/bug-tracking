<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Enums;

enum QueryOperatorEnum: string
{
    case EQUALS = '=';
    case NOT_EQUALS = '!=';
    case GREATER_THAN = '>';
    case LESSER_THAN = '<';
    case GREATER_THAN_EQUAL = '>=';
    case LESSER_THAN_EQUAL = '<=';
}

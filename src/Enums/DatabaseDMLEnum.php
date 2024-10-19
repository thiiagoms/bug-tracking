<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Enums;

enum DatabaseDMLEnum: string
{
    case DML_TYPE_SELECT = 'SELECT';
    case DML_TYPE_INSERT = 'INSERT';
    case DML_TYPE_UPDATE = 'UPDATE';
    case DML_TYPE_DELETE = 'DELETE';
}

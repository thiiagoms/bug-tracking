<?php

declare(strict_types=1);

namespace Thiiagoms\Bugtracking\Repositories\BugReport;

use Thiiagoms\Bugtracking\Entities\BugReport;
use Thiiagoms\Bugtracking\Repositories\Repository;

class BugReportRepository extends Repository
{
    protected static string $table = 'reports';
    protected static string $className = BugReport::class;
}

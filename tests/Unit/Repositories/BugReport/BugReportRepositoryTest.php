<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\BugReport;

use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Database\QueryBuilder;
use Thiiagoms\Bugtracking\Entities\BugReport;
use Thiiagoms\Bugtracking\Factory\QueryBuilder\QueryBuilderFactory;
use Thiiagoms\Bugtracking\Repositories\BugReport\BugReportRepository;

class BugReportRepositoryTest extends TestCase
{
    private QueryBuilder $queryBuilder;

    private BugReportRepository $bugReportRepository;

    protected function setUp(): void
    {
        $this->queryBuilder = QueryBuilderFactory::make(
            'database',
            'pdo',
            ['db_name' => 'bug_app_testing']
        );

        $this->queryBuilder->beginTransaction();

        $this->bugReportRepository = new BugReportRepository(
            $this->queryBuilder
        );
    }

    private function generateDummyData(): BugReport
    {
        $bugReport = new BugReport();

        $bugReport
            ->setReportType('Type 2')
            ->setEmail('thiiagoms@proton.me')
            ->setLink('https://github.com/thiiagoms')
            ->setMessage('This is a dummy message');

        return $this->bugReportRepository->create($bugReport);
    }

    public function testItShouldReturnEntityWhenCreateRecord(): void
    {
        /** @var BugReport $newBugReport */
        $newBugReport = $this->generateDummyData();

        $this->assertInstanceOf(BugReport::class, $newBugReport);

        $this->assertSame('Type 2', $newBugReport->getReportType());
        $this->assertSame('thiiagoms@proton.me', $newBugReport->getEmail());
        $this->assertSame('https://github.com/thiiagoms', $newBugReport->getLink());
        $this->assertSame('This is a dummy message', $newBugReport->getMessage());
    }

    public function testItShouldReturnEntityWhenUpdateRecord(): void
    {
        /** @var BugReport $newBugReport */
        $newBugReport = $this->generateDummyData();

        $bugReport = $this->bugReportRepository->find($newBugReport->getId());

        $bugReport
            ->setMessage('this is from update method')
            ->setLink('https://newlink.com/image.png');

        /** @var BugReport $updateBugReport */
        $updateBugReport = $this->bugReportRepository->update($bugReport);

        $this->assertInstanceOf(BugReport::class, $updateBugReport);
        $this->assertSame('this is from update method', $updateBugReport->getMessage());
        $this->assertSame('https://newlink.com/image.png', $updateBugReport->getLink());

        $this->assertNotSame($newBugReport, $updateBugReport);
    }

    public function testItShouldReturnNullWhenDeleteRecord(): void
    {
        /** @var BugReport $newBugReport */
        $newBugReport = $this->generateDummyData();

        /** @var null $result */
        $result = $this->bugReportRepository->delete($newBugReport);

        $this->assertNull($result);
    }

    public function testItShouldReturnEntityWhenFindRecord(): void
    {
        $this->generateDummyData();

        $results = $this->bugReportRepository->findBy([
            ['report_type', '=', 'Type 2'],
            ['email', '=', 'thiiagoms@proton.me'],
        ]);

        $this->assertIsArray($results);

        /** @var BugReport $bugReport */
        $bugReport = $results[0];

        $this->assertInstanceOf(BugReport::class, $bugReport);
        $this->assertSame('Type 2', $bugReport->getReportType());
        $this->assertSame('thiiagoms@proton.me', $bugReport->getEmail());
    }

    protected function tearDown(): void
    {
        $this->queryBuilder->rollback();
    }
}

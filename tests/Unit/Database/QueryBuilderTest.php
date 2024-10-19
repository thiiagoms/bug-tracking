<?php

declare(strict_types=1);

namespace Tests\Unit\Database;

use PHPUnit\Framework\TestCase;
use Thiiagoms\Bugtracking\Database\QueryBuilder;
use Thiiagoms\Bugtracking\Factory\QueryBuilder\QueryBuilderFactory;

class QueryBuilderTest extends TestCase
{
    private QueryBuilder $queryBuilder;

    protected function setUp(): void
    {
        $this->queryBuilder = QueryBuilderFactory::make(
            'database',
            'pdo',
            ['db_name' => 'bug_app_testing']
        );

        $this->queryBuilder->beginTransaction();
    }

    private function generateDummyData(): int
    {
        $data = [
            'report_type' => 'Report Type 1',
            'message' => 'This is a dummy message',
            'email' => 'thiiagoms@proton.me',
            'link' => 'https://link.com',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $id = $this->queryBuilder->table('reports')->create($data);

        return $id;
    }

    public function testItShouldReturnReportIdWhenCanCreateReportRecord(): void
    {
        $id = $this->generateDummyData();

        $this->assertNotNull($id);
        $this->assertIsInt($id);
    }

    public function testItShouldReturnResultWhenPerformSelectQuery(): void
    {
        $id = $this->generateDummyData();

        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where(column: 'id', value: $id)
            ->runQuery()
            ->first();

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);

        $this->assertEquals($id, $result->id);
    }

    public function testItShouldReturnReporWhenPerformSelectWithMultipleWhereConditions(): void
    {
        $id = $this->generateDummyData();

        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->where(column: 'id', value: $id)
            ->where(column: 'report_type', value: 'Report Type 1')
            ->runQuery()
            ->first();

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);

        $this->assertEquals($id, $result->id);
        $this->assertEquals('Report Type 1', $result->report_type);
    }

    public function testItShouldReturnReportWhenPerformRawQuery(): void
    {
        $this->generateDummyData();

        $result = $this->queryBuilder->raw('SELECT * FROM reports;')->get()[0];

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);
    }

    public function testItShouldReturnReportWhenPerformFindById(): void
    {
        $id = $this->generateDummyData();

        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->find($id);

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);

        $this->assertEquals($id, $result->id);
    }

    public function testItShouldReturnResultWhenPerformDFindOneByValueQuery(): void
    {
        $id = $this->generateDummyData();

        $result = $this->queryBuilder
            ->table('reports')
            ->select('*')
            ->findOneBy('report_type', 'Report Type 1');

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);

        $this->assertEquals($id, $result->id);
        $this->assertEquals('Report Type 1', $result->report_type);
    }

    public function testItShouldUpdateRecordWhenPerformUpdateQuery(): void
    {
        $id = $this->generateDummyData();

        $affectedRows = $this->queryBuilder
            ->table('reports')
            ->update([
                'report_type' => 'Report Type 1 Updated',
                'message' => 'This is a dummy message updated',
                'email' => 'thiiagoms@proton.me updated',
                'link' => 'https://link.com updated',
                'created_at' => date('Y-m-d H:i:s'),
            ])
            ->where(column: 'id', value: $id)
            ->runQuery()
            ->affected();

        $this->assertNotNull($affectedRows);
        $this->assertIsInt($affectedRows);
        $this->assertEquals($affectedRows, 1);

        $result = $this->queryBuilder->select('*')->find($id);

        $this->assertNotNull($result);
        $this->assertIsObject($result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('report_type', $result);
        $this->assertObjectHasProperty('message', $result);
        $this->assertObjectHasProperty('link', $result);
        $this->assertObjectHasProperty('email', $result);
        $this->assertObjectHasProperty('created_at', $result);

        $this->assertEquals($id, $result->id);
        $this->assertEquals('Report Type 1 Updated', $result->report_type);
        $this->assertEquals('This is a dummy message updated', $result->message);
        $this->assertEquals('thiiagoms@proton.me updated', $result->email);
        $this->assertEquals('https://link.com updated', $result->link);
        $this->assertEquals(date('Y-m-d H:i:s'), $result->created_at);
    }

    public function testItShouldDestroyRecordWhenPerformDeleteQuery(): void
    {
        $id = $this->generateDummyData();

        $affectedRows = $this->queryBuilder
            ->table('reports')
            ->where(column: 'id', value: $id)
            ->delete()
            ->runQuery()
            ->affected();

        $this->assertNotNull($affectedRows);
        $this->assertIsInt($affectedRows);
        $this->assertEquals($affectedRows, 1);

        $result = $this->queryBuilder
            ->select('*')
            ->find($id);

        $this->assertNull($result);
    }

    protected function tearDown(): void
    {
        $this->queryBuilder->rollback();
    }
}

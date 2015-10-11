<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Queue\Task;

use CodeCollab\Queue\Task\Postgres;

class PostgresTest extends \PHPUnit_Framework_TestCase
{
    protected $pdoMock;

    protected $taskData;

    public function setUp()
    {
        $this->pdoMock = $this
            ->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->taskData = [
            'id'        => 1,
            'type'      => 'Test',
            'timestamp' => '2015-10-11 14:49:51',
            'schedule'  => '2015-10-11 14:52:19',
            'data'      => '[]',
        ];
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Queue\Task\Task', new Postgres($this->pdoMock, $this->taskData));
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     */
    public function testValidateDataThrowsUpOnMissingIdField()
    {
        unset($this->taskData['id']);

        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidDataException',
            'Trying to create a task with invalid data. Missing field (`id`).'
        );

        new Postgres($this->pdoMock, $this->taskData);
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     */
    public function testValidateDataThrowsUpOnMissingTypeField()
    {
        unset($this->taskData['type']);

        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidDataException',
            'Trying to create a task with invalid data. Missing field (`type`).'
        );

        new Postgres($this->pdoMock, $this->taskData);
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     */
    public function testValidateDataThrowsUpOnMissingTimestampField()
    {
        unset($this->taskData['timestamp']);

        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidDataException',
            'Trying to create a task with invalid data. Missing field (`timestamp`).'
        );

        new Postgres($this->pdoMock, $this->taskData);
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     */
    public function testValidateDataThrowsUpOnMissingScheduleField()
    {
        unset($this->taskData['schedule']);

        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidDataException',
            'Trying to create a task with invalid data. Missing field (`schedule`).'
        );

        new Postgres($this->pdoMock, $this->taskData);
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     */
    public function testValidateDataThrowsUpOnMissingDataField()
    {
        unset($this->taskData['data']);

        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidDataException',
            'Trying to create a task with invalid data. Missing field (`data`).'
        );

        new Postgres($this->pdoMock, $this->taskData);
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getId
     */
    public function testGetId()
    {
        $this->assertSame(1, (new Postgres($this->pdoMock, $this->taskData))->getId());
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getType
     */
    public function testGetType()
    {
        $this->assertSame('Test', (new Postgres($this->pdoMock, $this->taskData))->getType());
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getTimestamp
     */
    public function testGetTimestamp()
    {
        $timestamp = (new Postgres($this->pdoMock, $this->taskData))->getTimestamp();

        $this->assertInstanceOf('DateTime', $timestamp);
        $this->assertSame($this->taskData['timestamp'], $timestamp->format('Y-m-d H:i:s'));
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getSchedule
     */
    public function testGetSchedule()
    {
        $schedule = (new Postgres($this->pdoMock, $this->taskData))->getSchedule();

        $this->assertInstanceOf('DateTime', $schedule);
        $this->assertSame($this->taskData['schedule'], $schedule->format('Y-m-d H:i:s'));
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getData
     */
    public function testGetDataReturnsDataOnValidKey()
    {
        $this->taskData['data'] = json_encode(['foo' => 'bar']);

        $this->assertSame('bar', (new Postgres($this->pdoMock, $this->taskData))->getData('foo'));
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::getData
     */
    public function testGetDataThrowsUpOnValidKey()
    {
        $this->setExpectedException(
            'CodeCollab\Queue\Task\InvalidPropertyException',
            'Invalid property (`foo`).'
        );

        (new Postgres($this->pdoMock, $this->taskData))->getData('foo');
    }

    /**
     * @covers CodeCollab\Queue\Task\Postgres::__construct
     * @covers CodeCollab\Queue\Task\Postgres::validateData
     * @covers CodeCollab\Queue\Task\Postgres::parseData
     * @covers CodeCollab\Queue\Task\Postgres::delete
     */
    public function testDelete()
    {
        $stmtMock = $this->getMock('PDOStatement');

        $stmtMock
            ->expects($this->once())
            ->method('execute')
            ->with($this->equalTo(['id' => 1]))
        ;

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo('DELETE FROM queue WHERE id = :id'))
            ->willReturn($stmtMock)
        ;

        (new Postgres($this->pdoMock, $this->taskData))->delete();
    }
}

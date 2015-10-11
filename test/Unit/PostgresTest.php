<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Queue;

use CodeCollab\Queue\Postgres;

class PostgresTest extends \PHPUnit_Framework_TestCase
{
    protected $pdoMock;

    protected $pidMock;

    protected $workerFactoryMock;

    public function setUp()
    {
        $this->pdoMock = $this
            ->getMockBuilder('PDO')
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $this->pidMock           = $this->getMock('CodeCollab\Queue\Pid\Pid');
        $this->workerFactoryMock = $this->getMock('CodeCollab\Queue\Worker\Builder');
    }

    /**
     * @covers CodeCollab\Queue\Postgres::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf(
            'CodeCollab\Queue\Queue',
            new Postgres($this->pdoMock, $this->pidMock, $this->workerFactoryMock)
        );
    }

    /**
     * @covers CodeCollab\Queue\Postgres::__construct
     * @covers CodeCollab\Queue\Postgres::start
     */
    public function testStartWhenAlreadyRunning()
    {
        $this->pidMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(false)
        ;

        $this->pdoMock
            ->expects($this->never())
            ->method($this->anything())
        ;

        $this->assertNull((new Postgres($this->pdoMock, $this->pidMock, $this->workerFactoryMock))->start());
    }

    /**
     * @covers CodeCollab\Queue\Postgres::__construct
     * @covers CodeCollab\Queue\Postgres::start
     * @covers CodeCollab\Queue\Postgres::run
     * @covers CodeCollab\Queue\Postgres::isCleared
     */
    public function testRunNotClearedYet()
    {
        $this->markTestSkipped('Cannot currently be tested, because the sleep call is blocking');

        return;

        $this->pidMock
            ->expects($this->once())
            ->method('create')
            ->willReturn(true)
        ;

        $stmtMock0 = $this->getMock('PDOStatement');

        $stmtMock1 = $this->getMock('PDOStatement');

        $stmtMock1
            ->expects($this->once())
            ->method('fetchColumn')
            ->with($this->equalTo(0))
            ->willReturn(1)
        ;

        $this->pdoMock
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock0)
        ;

        $this->pdoMock
            ->expects($this->once())
            ->method('query')
            ->willReturn($stmtMock1)
        ;

        $queue = new Postgres($this->pdoMock, $this->pidMock, $this->workerFactoryMock);

        $this->assertNull($queue->start());

        $queue = null;
    }
}

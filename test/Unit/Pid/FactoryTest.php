<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Queue\Pid;

use CodeCollab\Queue\Pid\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers CodeCollab\Queue\Pid\Factory::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Queue\Pid\Builder', new Factory(TEST_DATA_DIR));
    }

    /**
     * @covers CodeCollab\Queue\Pid\Factory::__construct
     * @covers CodeCollab\Queue\Pid\Factory::build
     */
    public function testBuild()
    {
        $pid = (new Factory(TEST_DATA_DIR))->build('test.pid');

        $this->assertInstanceOf('CodeCollab\Queue\Pid\Pid', $pid);
        $this->assertInstanceOf('CodeCollab\Queue\Pid\LockFile', $pid);
    }
}

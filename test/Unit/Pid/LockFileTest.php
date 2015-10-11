<?php declare(strict_types=1);

namespace CodeCollabTest\Unit\Queue\Pid;

use CodeCollab\Queue\Pid\LockFile;

class LockFileTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // precaution to at least do our best to cleanup if something ever went wrong
        @unlink(TEST_DATA_DIR . '/test.pid');
    }

    public function tearDown()
    {
        // precaution to at least do our best to cleanup if something ever went wrong
        @unlink(TEST_DATA_DIR . '/test.pid');
    }

    /**
     * @covers CodeCollab\Queue\Pid\LockFile::__construct
     */
    public function testImplementsCorrectInterface()
    {
        $this->assertInstanceOf('CodeCollab\Queue\Pid\Pid', new LockFile(TEST_DATA_DIR . '/test.pid'));
    }

    /**
     * @covers CodeCollab\Queue\Pid\LockFile::__construct
     * @covers CodeCollab\Queue\Pid\LockFile::create
     */
    public function testCreateWhenBeingAbleToAquireLock()
    {
        $this->assertTrue((new LockFile(TEST_DATA_DIR . '/test.pid'))->create());
    }

    /**
     * @covers CodeCollab\Queue\Pid\LockFile::__construct
     * @covers CodeCollab\Queue\Pid\LockFile::create
     */
    public function testCreateWhenBeingAbleToAquireLockAfterRelease()
    {
        $this->assertTrue((new LockFile(TEST_DATA_DIR . '/test.pid'))->create());
        $this->assertTrue((new LockFile(TEST_DATA_DIR . '/test.pid'))->create());
    }

    /**
     * @covers CodeCollab\Queue\Pid\LockFile::__construct
     * @covers CodeCollab\Queue\Pid\LockFile::create
     */
    public function testCreateWhenNotBeingAbleToAquireLock()
    {
        $pid1 = new LockFile(TEST_DATA_DIR . '/test.pid');
        $pid2 = new LockFile(TEST_DATA_DIR . '/test.pid');

        $this->assertTrue($pid1->create());

        $this->assertFalse($pid2->create());
    }
}

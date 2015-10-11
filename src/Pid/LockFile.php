<?php declare(strict_types=1);
/**
 * Lock file pid implementation
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Pid
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CodeCollab\Queue\Pid;

/**
 * Lock file pid implementation
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Pid
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class LockFile implements Pid
{
    /**
     * @var string The name of the pid file
     */
    private $filename;

    /**
     * @var resource The file handle of the pid file
     */
    private $pidHandle;

    /**
     * Creates instance
     *
     * @param string $filename The name of the pid file
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Tries to create the pid file
     *
     * This method checks whether a lock can be aquired and when this is the case creates a lock.
     * This basically violates CQRS, but ¯\_(ツ)_/¯
     *
     * @return bool True when a lock has been aquired
     */
    public function create(): bool
    {
        $this->pidHandle = fopen($this->filename, 'w');

        if (!flock($this->pidHandle, LOCK_EX|LOCK_NB, $result)) {
            return false;
        }

        return true;
    }
}

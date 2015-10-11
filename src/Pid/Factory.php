<?php declare(strict_types=1);
/**
 * Pid factory class
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
 * Pid factory class
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Pid
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Factory implements Builder
{
    /**
     * @var string The directory in which to write the pid files
     */
    private $path;

    /**
     * Creates instance
     *
     * @param string $path The directory in which to write the pid files
     */
    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/');
    }

    /**
     * Builds a new pid instance
     *
     * @param string $name The name of the pid file
     */
    public function build(string $name): Pid
    {
        return new LockFile($this->path . $name);
    }
}

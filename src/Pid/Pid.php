<?php declare(strict_types=1);
/**
 * Pid interface
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
 * Pid interface
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Pid
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Pid
{
    /**
     * Tries to create the pid file
     *
     * This method checks whether a lock can be aquired and when this is the case creates a lock.
     * This basically violates CQRS, but ¯\_(ツ)_/¯
     *
     * @return bool True when a lock has been aquired
     */
    public function create(): bool;
}

<?php declare(strict_types=1);
/**
 * Task interface
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Task
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CodeCollab\Queue\Task;

/**
 * Task interface
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Task
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Task
{
    /**
     * Gets the id
     *
     * @return int The id
     */
    public function getId(): int;

    /**
     * Gets the type
     *
     * @return string The type
     */
    public function getType(): string;

    /**
     * Gets the timestamp
     *
     * @return \DateTime The timestamp
     */
    public function getTimestamp(): \DateTime;

    /**
     * Gets the schedule
     *
     * @return \DateTime The schedule
     */
    public function getSchedule(): \DateTime;

    /**
     * Gets custom data
     *
     * @param string $key The key to retrieve
     *
     * @return string The data
     *
     * @throws \CodeCollab\Queue\Task\InvalidPropertyException When trying to access an invalid property
     */
    public function getData(string $key): string;

    /**
     * Deletes the task
     */
    public function delete();
}

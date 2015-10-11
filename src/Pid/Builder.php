<?php declare(strict_types=1);
/**
 * Interface for pid factories
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
 * Interface for pid factories
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Pid
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Builder
{
    /**
     * Builds a new pid instance
     *
     * @param string $name The name of the pid file
     */
    public function build(string $name): Pid;
}

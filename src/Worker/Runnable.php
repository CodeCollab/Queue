<?php declare(strict_types=1);
/**
 * Interface for workers
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Worker
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CodeCollab\Queue\Worker;

/**
 * Interface for workers
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Worker
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Runnable
{
    /**
     * Runs the worker
     */
    public function run();
}

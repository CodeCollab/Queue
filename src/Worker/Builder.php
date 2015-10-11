<?php declare(strict_types=1);
/**
 * Interface for worker factories
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

use CodeCollab\Queue\Task;

/**
 * Interface for worker factories
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Worker
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Builder
{
    /**
     * Builds the worker
     *
     * @param \CodeCollab\Queue\Task $task The task based on which the worker has to be build
     *
     * @return \CodeCollab\Queue\Worker\Runnable The worker
     */
    public function build(Task $task): Runnable;
}

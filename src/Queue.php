<?php declare(strict_types=1);
/**
 * Queue interface
 *
 * PHP version 7.0
 *
 * @category   CodeCollab
 * @package    Queue
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2015 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace CodeCollab\Queue;

/**
 * Queue interface
 *
 * @category   CodeCollab
 * @package    Queue
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
interface Queue
{
    /**
     * Starts the queue
     */
    public function start();
}

<?php declare(strict_types=1);
/**
 * Exception which gets thrown when the task data is not valid
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
 * Exception which gets thrown when the task data is not valid
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Task
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class InvalidDataException extends \Exception
{
}

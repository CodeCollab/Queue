<?php declare(strict_types=1);
/**
 * Exception which gets thrown when trying to access a invalid data proprty of a task
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
 * Exception which gets thrown when trying to access a invalid data proprty of a task
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Task
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class InvalidPropertyException extends \Exception
{
}

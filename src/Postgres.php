<?php declare(strict_types=1);
/**
 * Postgres queue handler
 *
 * This class represent a work queue, It will keep polling the database for work to do
 * and when needed spawns a new worker process to run specific tasks
 *
 * Note: a relational database is one of the worst tools for the job
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

use CodeCollab\Queue\Pid\Pid;
use CodeCollab\Queue\Worker\Builder as WorkerBuilder;
use CodeCollab\Queue\Task\Postgres as PostgresTask;

/**
 * Postgres queue handler
 *
 * @category   CodeCollab
 * @package    Queue
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Postgres implements Queue
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * @var \CodeCollab\Queue\Pid\Pid Instance of a pid file handler
     */
    private $pid;

    /**
     * @var \CodeCollab\Queue\Worker\Builder Instance of a worker builder
     */
    private $workerFactory;

    /**
     * @var int The second to sleep between checking the database for new tasks
     */
    private $interval;

    /**
     * Creates instance
     *
     * @param \PDO                             $dbConnection  The database connection
     * @param \CodeCollab\Queue\Pid\Pid        $pid           Instance of a pid file handler
     * @param \CodeCollab\Queue\Worker\Builder $workerFactory Instance of a worker builder
     * @param int                              $interval      The interval between checking the database for new tasks
     */
    public function __construct(\PDO $dbConnection, Pid $pid, WorkerBuilder $workerFactory, int $interval = 5)
    {
        $this->dbConnection  = $dbConnection;
        $this->pid           = $pid;
        $this->workerFactory = $workerFactory;
        $this->interval      = $interval;
    }

    /**
     * Starts the queue
     *
     * When starting the queue a pid file is created and locked to prevent spawning multiple queue scripts
     */
    public function start()
    {
        set_time_limit(0);

        if (!$this->pid->create()) {
            return;
        }

        $this->run();
    }

    /**
     * Runs the queue
     */
    private function run()
    {
        $query = 'UPDATE queue';
        $query.= ' SET started = :started';
        $query.= ' WHERE schedule < :schedule';
        $query.= ' AND started IS NULL';
        $query.= ' RETURNING id, type, timestamp, schedule, data';

        $stmt = $this->dbConnection->prepare($query);

        while (true) {
            // we are waiting for running tasks to finish
            if ($this->isCleared()) {
                $datetime = new \DateTime();

                $stmt->execute([
                    'started'  => $datetime->format('Y-m-d H:i:s'),
                    'schedule' => $datetime->format('Y-m-d H:i:s'),
                ]);

                foreach ($stmt->fetchAll() as $task) {
                    $worker = $this->workerFactory->build(new PostgresTask($this->dbConnection, $task));
                    $worker->run();
                }
            }

            sleep($this->interval);
        }
    }

    /**
     * Checks whether all started jobs has been finished
     *
     * @return bool True when the queue has been cleared
     */
    private function isCleared(): bool
    {
        $query = 'SELECT COUNT(id)';
        $query.= ' FROM queue';
        $query.= ' WHERE started IS NOT NULL';

        $stmt = $this->dbConnection->query($query);

        return !$stmt->fetchColumn(0);
    }
}

<?php declare(strict_types=1);
/**
 * Postgres task implementation
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
 * Postgres task implementation
 *
 * @category   CodeCollab
 * @package    Queue
 * @subpackage Task
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class Postgres implements Task
{
    /**
     * @var \PDO The database connection
     */
    private $dbConnection;

    /**
     * @var int The id of the task
     */
    private $id;

    /**
     * @var string The type of the task
     */
    private $type;

    /**
     * @var \DateTime The timestamp of the task
     */
    private $timestamp;

    /**
     * @var \DateTime The schedule of the task
     */
    private $schedule;

    /**
     * @var array The data of the task
     */
    private $data = [];

    /**
     * Creates instance
     *
     * @param \PDO  $dbConnection The database connection
     * @param array $data         The task data
     */
    public function __construct(\PDO $dbConnection, array $data)
    {
        $this->dbConnection = $dbConnection;

        $this->validateData($data);
        $this->parseData($data);
    }

    /**
     * Validates the task data
     *
     * @param array $data The task data
     *
     * @throws \CodeCollab\Queue\Task\InvalidDataException When the task data is not valid
     */
    private function validateData(array $data)
    {
        $requiredFields = ['id', 'type', 'timestamp', 'schedule', 'data'];

        foreach ($requiredFields as $requiredField) {
            if (array_key_exists($requiredField, $data)) {
                continue;
            }

            throw new InvalidDataException(
                'Trying to create a task with invalid data. Missing field (`' . $requiredField . '`).'
            );
        }
    }

    /**
     * Parses the task data
     *
     * @param array $data The task data
     */
    private function parseData(array $data)
    {
        $this->id        = (int) $data['id'];
        $this->type      = $data['type'];
        $this->timestamp = new \DateTime($data['timestamp']);
        $this->schedule  = new \DateTime($data['schedule']);
        $this->data      = json_decode($data['data'], true);
    }

    /**
     * Gets the id
     *
     * @return int The id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the type
     *
     * @return string The type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Gets the timestamp
     *
     * @return \DateTime The timestamp
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * Gets the schedule
     *
     * @return \DateTime The schedule
     */
    public function getSchedule(): \DateTime
    {
        return $this->schedule;
    }

    /**
     * Gets custom data
     *
     * @param string $key The key to retrieve
     *
     * @return string The data
     *
     * @throws \CodeCollab\Queue\Task\InvalidPropertyException When trying to access an invalid property
     */
    public function getData(string $key): string
    {
        if (!array_key_exists($key, $this->data)) {
            throw new InvalidPropertyException('Invalid property (`' . $key . '`).');
        }

        return $this->data[$key];
    }

    /**
     * Deletes the task
     */
    public function delete()
    {
        $query = 'DELETE FROM queue';
        $query.= ' WHERE id = :id';

        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute([
            'id' => $this->id,
        ]);
    }
}

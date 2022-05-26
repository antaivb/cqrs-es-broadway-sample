<?php

namespace App\Infrastructure\Shared\Persistence;

use App\Domain\Shared\Snapshot\SnapshotEventStore;
use App\Infrastructure\Shared\Snapshot\Snapshot;
use Broadway\Domain\AggregateRoot;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;
use ReflectionException;

class DBALSnapshotEventStore implements SnapshotEventStore
{
    public function __construct(
        private Connection $connection,
        private string $tableName
    ) {}

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function append(AggregateRoot $aggregateRoot): void
    {
        $snapshot = $this->load($aggregateRoot->getAggregateRootId());
        $this->connection->beginTransaction();

        try {
            if (null === $snapshot) {
                $this->insertMessage($this->connection, $aggregateRoot);
            } else {
                $this->updateMessage($this->connection, $aggregateRoot);
            }
            $this->connection->commit();
        } catch (\Exception $exception) {
            $this->connection->rollBack();
        }
    }

    /**
     * @param $id
     * @return Snapshot|null
     * @throws Exception
     * @throws ReflectionException
     */
    public function load($id): ?Snapshot
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $id);
        $result = $statement->executeQuery();

        $response = $result->fetchAssociative();
        return ($this->isValidSnapshot($response))
            ? Snapshot::create($response)
            : null;
    }

    /**
     * @throws Exception
     */
    private function insertMessage(Connection $connection, AggregateRoot $aggregateRoot): void
    {
        $data = [
            'uuid' => $aggregateRoot->getAggregateRootId(),
            'playhead' => $aggregateRoot->getPlayhead(),
            'payload' => json_encode($aggregateRoot->serialize()),
            'recorded_on' => (new \DateTime())->format('Y-m-d H:i:s'),
            'type' => $aggregateRoot::class
        ];

        $connection->insert($this->tableName, $data);
    }

    /**
     * @throws Exception
     */
    private function updateMessage(Connection $connection, AggregateRoot $aggregateRoot): void
    {
        $data = [
            'playhead' => $aggregateRoot->getPlayhead(),
            'payload' => json_encode($aggregateRoot->serialize()),
            'recorded_on' => (new \DateTime())->format('Y-m-d H:i:s'),
        ];

        $connection->update($this->tableName, $data, ['uuid' => $aggregateRoot->getAggregateRootId()]);
    }

    /**
     * @throws Exception
     */
    private function prepareLoadStatement(): Statement
    {
        $query = 'SELECT uuid, playhead, payload, recorded_on, type
            FROM '.$this->tableName.'
            WHERE uuid = ?
            ORDER BY playhead ASC';

        return $this->connection->prepare($query);
    }

    private function isValidSnapshot(array|bool $response): bool
    {
        return is_array($response) &&
            array_key_exists('playhead', $response) &&
            array_key_exists('type', $response) &&
            array_key_exists('payload', $response);
    }
}

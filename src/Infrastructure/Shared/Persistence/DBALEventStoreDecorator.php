<?php

namespace App\Infrastructure\Shared\Persistence;

use App\Domain\Shared\Upcasting\UpcasterChain;
use App\Infrastructure\Shared\Event\DomainEventUpcaster;
use App\Infrastructure\Shared\Upcasting\SequentialUpcasterChain;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\EventStore\EventStreamNotFoundException;
use Broadway\Serializer\Serializer;
use Broadway\UuidGenerator\Converter\BinaryUuidConverterInterface;
use Doctrine\DBAL\Connection;

class DBALEventStoreDecorator extends DBALEventStore
{
    private UpcasterChain $upcasterChain;

    public function __construct(
        DomainEventUpcaster $domainEventUpcaster,
        Connection $connection,
        Serializer $payloadSerializer,
        Serializer $metadataSerializer,
        string $tableName,
        bool $useBinary,
        BinaryUuidConverterInterface $binaryUuidConverter = null
    )
    {
        $this->upcasterChain = new SequentialUpcasterChain([$domainEventUpcaster]);
        parent::__construct(
            $connection,
            $payloadSerializer,
            $metadataSerializer,
            $tableName,
            $useBinary,
            $binaryUuidConverter
        );
    }

    public function load($id): DomainEventStream
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $this->convertIdentifierToStorageValue($id));
        $statement->bindValue(2, 0);
        $result = $statement->executeQuery();

        $events = [];
        while ($row = $result->fetchAssociative()) {
            $events[] = $this->deserializeEvent($row);
        }

        if (empty($events)) {
            throw new EventStreamNotFoundException(sprintf('EventStream not found for aggregate with id %s for table', $id));
        }

        return new DomainEventStream($events);
    }

    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        $statement = $this->prepareLoadStatement();
        $statement->bindValue(1, $this->convertIdentifierToStorageValue($id));
        $statement->bindValue(2, $playhead);
        $result = $statement->executeQuery();

        $events = [];
        while ($row = $result->fetchAssociative()) {
            $events[] = $this->deserializeEvent($row);
        }

        return new DomainEventStream($events);
    }

    private function deserializeEvent(array $row): DomainMessage
    {
        $playhead = (int) $row['playhead'];
        $payload = json_decode($row['payload'], true);
        $payload = $this->upcasterChain->upcast($payload, $playhead);

        $row['payload'] = json_encode($payload);
        return $this->deserializeEventReflection($row);
    }

    private function prepareLoadStatement()
    {
        $reflectionMethod = new \ReflectionMethod(DBALEventStore::class, 'prepareLoadStatement');
        return $reflectionMethod->invoke($this);
    }

    private function convertIdentifierToStorageValue($id)
    {
        $reflectionMethod = new \ReflectionMethod(DBALEventStore::class, 'convertIdentifierToStorageValue');
        return $reflectionMethod->invoke($this, $id);
    }

    private function deserializeEventReflection($row)
    {
        $reflectionMethod = new \ReflectionMethod(DBALEventStore::class, 'deserializeEvent');
        return $reflectionMethod->invoke($this, $row);
    }
}

<?php

namespace App\Infrastructure\Shared\Persistence;

use App\Domain\Shared\Upcasting\UpcasterChain;
use App\Infrastructure\Shared\Event\DomainEventUpcaster;
use App\Infrastructure\Shared\Upcasting\SequentialUpcasterChain;
use Broadway\Domain\DomainMessage;
use Broadway\EventStore\Dbal\DBALEventStore;
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

    protected function deserializeEvent(array $row): DomainMessage
    {
        $playhead = (int) $row['playhead'];
        $payload = json_decode($row['payload'], true);
        $payload = $this->upcasterChain->upcast($payload, $playhead);

        $row['payload'] = json_encode($payload);
        return parent::deserializeEvent($row);
    }
}

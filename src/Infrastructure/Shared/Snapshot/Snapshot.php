<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Snapshot;

use Broadway\Domain\AggregateRoot;
use Broadway\Domain\DateTime;
use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use ReflectionException;

class Snapshot
{
    private int $playhead;
    private AggregateRoot $aggregateRoot;

    private function __construct() {}

    /**
     * @throws ReflectionException
     */
    public static function create(array $parameters): self
    {
        $snapshot = new self();

        $class = new \ReflectionClass($parameters['type']);
        $aggregate = $class->newInstanceWithoutConstructor();

        $snapshot->aggregateRoot = $aggregate->deserialize(json_decode($parameters['payload'], true));
        $snapshot->playhead = $parameters['playhead'];
        $snapshot->recreatePlayhead();

        return $snapshot;
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    public function getAggregateRoot(): AggregateRoot
    {
        return $this->aggregateRoot;
    }

    public function recreatePlayhead(): void
    {
        $aggregateRoot = $this->getAggregateRoot();

        $playheadReflection = new \ReflectionProperty(EventSourcedAggregateRoot::class, 'playhead');
        ($playheadReflection)->setValue($aggregateRoot, $this->getPlayhead());
    }
}

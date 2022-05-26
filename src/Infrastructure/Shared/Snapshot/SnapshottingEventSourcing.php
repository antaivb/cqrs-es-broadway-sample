<?php

namespace App\Infrastructure\Shared\Snapshot;

use App\Domain\Shared\Snapshot\SnapshotEventStore;
use Broadway\Domain\AggregateRoot;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\AggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Doctrine\DBAL\Exception;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

class SnapshottingEventSourcing extends EventSourcingRepository
{
    public const EVENT_COUNT_DEFAULT = 20;

    public function __construct(
        private SnapshotEventStore $snapshotStore,
        private EventStore $eventStore,
        EventBus $eventBus,
        string $aggregateClass,
        AggregateFactory $aggregateFactory,
        array $eventStreamDecorators = [],
        private $eventCount = self::EVENT_COUNT_DEFAULT
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            $aggregateClass,
            $aggregateFactory,
            $eventStreamDecorators
        );
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function loadWithSnapshot($id): AggregateRoot
    {
        $snapshot = $this->snapshotStore->load($id);
        if (null === $snapshot) {
            return $this->load($id);
        }

        $aggregateRoot = $snapshot->getAggregateRoot();

        $aggregateRoot->initializeState(
            $this->eventStore->loadFromPlayhead($id, $snapshot->getPlayhead() + 1)
        );

        return $aggregateRoot;
    }

    public function saveWithSnapshot(AggregateRoot $aggregate): void
    {
        $takeSnapshot = $this->shouldSnapshot($aggregate);
        $this->save($aggregate);

        if ($takeSnapshot) {
            $this->takeSnapshot($aggregate);
        }
    }

    private function shouldSnapshot(AggregateRoot $aggregateRoot): bool
    {
        $clonedAggregateRoot = clone $aggregateRoot;

        foreach ($clonedAggregateRoot->getUncommittedEvents() as $domainMessage) {
            if (0 === ($domainMessage->getPlayhead() + 1) % $this->eventCount) {
                return true;
            }
        }

        return false;
    }

    #[NoReturn]
    private function takeSnapshot(AggregateRoot $aggregate): void
    {
        $this->snapshotStore->append($aggregate);
    }
}

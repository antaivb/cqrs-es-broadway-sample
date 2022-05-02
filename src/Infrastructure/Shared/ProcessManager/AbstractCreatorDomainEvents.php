<?php

namespace App\Infrastructure\Shared\ProcessManager;

use Broadway\Domain\AggregateRoot;
use Broadway\EventStore\EventStreamNotFoundException;

abstract class AbstractCreatorDomainEvents
{
    abstract public function getElements(): ?array;

    abstract public function recreate($row): AggregateRoot;

    public function save(AggregateRoot $modelDomain): void
    {
        $domainEventStream = $modelDomain->getUncommittedEvents();
        $this->eventStore->append($modelDomain->getAggregateRootId(), $domainEventStream);
    }

    public function existEventSpecification(string $id): bool
    {
        try {
            $this->eventStore->load($id);
        } catch (EventStreamNotFoundException $e) {
            return false;
        }

        return true;
    }
}
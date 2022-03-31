<?php

declare(strict_types=1);

namespace App\Infrastructure\Session\Repository;

use App\Domain\Session\Exception\SessionNotFoundException;
use App\Domain\Session\Model\Session;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Repository\SessionStoreRepositoryInterface;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;

class SessionStoreRepository extends EventSourcingRepository implements SessionStoreRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Session::class,
            new ReflectionAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(Session $session): void
    {
        $this->save($session);
    }

    public function get(SessionId $id): Session
    {
        try {
            /** @var Session $session */
            $session = $this->load($id->toString());
        } catch (AggregateNotFoundException $e) {
            throw new SessionNotFoundException();
        }

        return $session;
    }
}

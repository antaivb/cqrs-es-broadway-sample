<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use App\Infrastructure\Shared\Persistence\DBALSnapshotEventStore;
use App\Infrastructure\Shared\Snapshot\SnapshottingEventSourcing;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;
use ReflectionException;
use Doctrine\DBAL\Exception;

class UserStoreRepository extends SnapshottingEventSourcing implements UserStoreRepositoryInterface
{
    private const NUM_EVENTS_TO_SNAPSHOT = 2;

    public function __construct(
        DBALSnapshotEventStore $snapshotStore,
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $snapshotStore,
            $eventStore,
            $eventBus,
            User::class,
            new ReflectionAggregateFactory(),
            $eventStreamDecorators,
            self::NUM_EVENTS_TO_SNAPSHOT
        );
    }

    public function store(User $user): void
    {
        $this->saveWithSnapshot($user);
    }

    public function get(UserId $id): User
    {
        try {
            /** @var User $user */
            $user = $this->loadWithSnapshot($id->toString());
        } catch (Exception|AggregateNotFoundException|ReflectionException $e) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

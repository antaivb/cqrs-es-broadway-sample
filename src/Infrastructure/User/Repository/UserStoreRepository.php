<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;

class UserStoreRepository extends EventSourcingRepository implements UserStoreRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new ReflectionAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(User $user): void
    {
        $this->save($user);
    }

    public function get(UserId $id): User
    {
        try {
            /** @var User $user */
            $user = $this->load($id->toString());
        } catch (AggregateNotFoundException $e) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}

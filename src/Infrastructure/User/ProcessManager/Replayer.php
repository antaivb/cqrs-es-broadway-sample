<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ProcessManager;

use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\ReadModel\UserView;
use Broadway\Domain\DomainMessage;
use Broadway\EventStore\Dbal\DBALEventStore;
use Broadway\EventStore\EventVisitor;
use Broadway\EventStore\Management\Criteria;
use JetBrains\PhpStorm\Pure;

class Replayer implements EventVisitor
{
    public function __construct(
        private DBALEventStore $eventStore,
        private UserRepositoryInterface $userRepository
    ) {}

    public function doWithEvent(DomainMessage $domainMessage): void
    {
        switch ($domainMessage->getType()) {
            case $this->getEventTypeFromClass(UserWasCreated::class):
                $user = UserView::fromSerializable($domainMessage->getPayload());
                $this->userRepository->save($user);
                break;
            default:
                var_dump('Other event ' . $domainMessage->getType());
                break;
        }
    }

    public function replayForEvent(array $eventTypes): void
    {
        $criteria = new Criteria();
        $criteria = $criteria->withEventTypes($this->getEventTypesFromClasses($eventTypes));

        $this->eventStore->visitEvents($criteria, $this);
    }

    #[Pure] private function getEventTypesFromClasses(array $classNames): array
    {
        $types = [];
        foreach ($classNames as $className) {
            $types[] = $this->getEventTypeFromClass($className);
        }

        return $types;
    }

    private function getEventTypeFromClass(string $className): string
    {
        return strtr($className, '\\', '.');
    }
}

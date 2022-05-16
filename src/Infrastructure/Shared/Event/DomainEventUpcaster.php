<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Event;

use App\Domain\Shared\Upcasting\Upcaster;
use App\Domain\User\Event\UserWasCreated;
use App\Infrastructure\User\Upcasting\UserUpcaster;

class DomainEventUpcaster implements Upcaster
{
    public function __construct(
        private UserUpcaster $userUpcaster
    ) {}

    public function supports(array $serializedEvent): bool
    {
        return $serializedEvent['class'] === UserWasCreated::class;
    }

    public function upcast(array $serializedEvent, int $playhead): array
    {
        return match ($serializedEvent['class']) {
            UserWasCreated::class => $this->userUpcaster->upcast($serializedEvent, $playhead),
            default => $serializedEvent
        };
    }
}

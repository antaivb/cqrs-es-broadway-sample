<?php

declare(strict_types=1);

namespace App\Infrastructure\Session\ReadModel\Projection;

use App\Domain\Session\Event\SessionWasCreated;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Infrastructure\Session\ReadModel\SessionView;
use Broadway\ReadModel\Projector;

final class SessionProjection extends Projector
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository,
    ) {}

    protected function applySessionWasCreated(SessionWasCreated $sessionWasCreated): void
    {
        $eventSerialized = $sessionWasCreated->serialize();
        $sessionReadModel = SessionView::deserialize($eventSerialized);

        $this->sessionRepository->insert($sessionReadModel);
    }
}

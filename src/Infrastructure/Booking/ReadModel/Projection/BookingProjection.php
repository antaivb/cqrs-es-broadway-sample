<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\ReadModel\Projection;

use App\Domain\Booking\Event\BookingWasCreated;
use App\Domain\Booking\Repository\BookingRepositoryInterface;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Booking\ReadModel\BookingView;
use Broadway\ReadModel\Projector;

final class BookingProjection extends Projector
{
    public function __construct(
        private BookingRepositoryInterface $bookingRepository,
        private SessionRepositoryInterface $sessionRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    protected function applyBookingWasCreated(BookingWasCreated $bookingWasCreated): void
    {
        $eventSerialized = $bookingWasCreated->serialize();

        $session = $this->sessionRepository->find($bookingWasCreated->sessionId()->toString());
        $user = $this->userRepository->findById($bookingWasCreated->userId()->toString());

        $eventSerialized['user'] = $user;
        $eventSerialized['session'] = $session;

        $bookingReadModel = BookingView::deserialize($eventSerialized);
        $this->bookingRepository->insert($bookingReadModel);
    }
}

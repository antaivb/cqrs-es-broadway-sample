<?php

namespace App\Infrastructure\Session\ProcessManager;

use App\Domain\Booking\Event\BookingWasCreated;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Domain\Shared\ValueObject\UpdatedAt;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class IncrementBookingProcessManager
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository,
        private LoggerInterface $logger
    ) {}

    #[NoReturn] public function __invoke(BookingWasCreated $bookingsWasCreated): void
    {
        $sessionReadModel = $this->sessionRepository->find($bookingsWasCreated->sessionId()->toString());

        $sessionReadModel->setUpdatedAt(UpdatedAt::fromString($bookingsWasCreated->creationDate()->toString()));
        $sessionReadModel->incrementNumBookings();

        $this->sessionRepository->insert($sessionReadModel);

        if ($sessionReadModel->numBookings() === 1) {
            $this->logger->notice('Send first confirmation email (FirstSessionBookingConfirmationSender)');
        }
    }
}
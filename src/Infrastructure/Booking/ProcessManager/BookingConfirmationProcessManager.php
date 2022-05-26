<?php

namespace App\Infrastructure\Booking\ProcessManager;

use App\Domain\Booking\Event\BookingWasCreated;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class BookingConfirmationProcessManager
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository,
        private LoggerInterface $logger
    ) {}

    #[NoReturn] public function __invoke(BookingWasCreated $bookingsWasCreated): void
    {
        $session = $this->sessionRepository->find($bookingsWasCreated->sessionId()->toString());
        if (!$bookingsWasCreated->sendConfirmation() || $session->when() < (new \DateTimeImmutable())) {
            return;
        }

        $this->logger->notice('Send Confirmation email (BookingConfirmationSender)');
    }
}
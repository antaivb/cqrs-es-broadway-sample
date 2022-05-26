<?php

namespace App\Infrastructure\User\ProcessManager;

use App\Domain\User\Event\UserWasCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWelcomeEmailProcessManager
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function __invoke(UserWasCreated $message): void
    {
        $this->logger->notice('--- Send Welcome Email to ' . $message->credentials()->email() . ' ---');
    }
}
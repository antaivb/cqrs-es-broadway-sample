<?php

namespace App\Infrastructure\User\ProcessManager;

use App\Domain\User\Event\UserWasCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWelcomeEmailProcessManager
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(UserWasCreated $message)
    {
        $this->logger->notice('------------------');
        $this->logger->notice('Send Welcome Email');
        $this->logger->notice($message->credentials()->email());
        $this->logger->notice('------------------');
    }
}
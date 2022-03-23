<?php

namespace App\Application\Event;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class EventHandler implements EventListener
{
    private MessageBusInterface $messageBus;
    private LoggerInterface $logger;

    public function __construct(MessageBusInterface $messageBus, LoggerInterface $logger)
    {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    public function handle(DomainMessage $domainMessage): void
    {
        $this->logger->critical('Handle');
        // $this->messageBus->dispatch();
    }
}

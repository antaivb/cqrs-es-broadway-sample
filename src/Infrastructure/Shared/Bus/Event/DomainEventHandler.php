<?php

namespace App\Infrastructure\Shared\Bus\Event;

use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class DomainEventHandler implements EventListener
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
        $event = $domainMessage->getPayload();
        $this->logger->notice('Event from Broadway bus detected => ' . get_class($event));

        try {
            $this->messageBus->dispatch($event);
        } catch (NoHandlerForMessageException $e) {
            $this->logger->notice('Error dispatching event to Symfony bus => ' . get_class($event));
        }
    }
}

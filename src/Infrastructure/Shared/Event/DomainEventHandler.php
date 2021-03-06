<?php

namespace App\Infrastructure\Shared\Event;

use App\Domain\User\Event\UserWasCreated;
use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class DomainEventHandler implements MessageSubscriberInterface, EventListener
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private LoggerInterface $logger
    ) {}

    public function handle(DomainMessage $domainMessage): void
    {
        $event = $domainMessage->getPayload();
        $this->logger->notice('--- Event detected => ' . get_class($event) . ' ---');

        try {
            $this->messageBus->dispatch($event);
        } catch (NoHandlerForMessageException $e) {
            $this->logger->notice('Error dispatching event to Symfony bus => ' . get_class($event));
        }
    }

    public function __invoke(DomainMessage $domainMessage): void
    {
        $this->logger->notice('--- Async Event from AMQP "event" queue detected ---');
        $this->handle($domainMessage);
    }

    public static function getHandledMessages(): iterable
    {
        yield DomainMessage::class => [
            'from_transport' => 'events',
            'bus' => 'messenger.bus.event.async',
        ];
    }
}

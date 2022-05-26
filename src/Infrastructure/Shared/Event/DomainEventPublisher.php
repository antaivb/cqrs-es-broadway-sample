<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Event;

use App\Infrastructure\Shared\Bus\AsyncEvent\MessengerAsyncEventBus;
use Broadway\Domain\DomainMessage;
use Broadway\EventHandling\EventListener;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class DomainEventPublisher implements EventSubscriberInterface, EventListener
{
    private array $messages = [];

    public function __construct(
        private LoggerInterface $logger,
        private MessengerAsyncEventBus $bus
    ) {}

    public function handle(DomainMessage $domainMessage): void
    {
        $this->messages[] = $domainMessage;
    }

    #[ArrayShape([KernelEvents::TERMINATE => "string"])]
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::TERMINATE => 'publish'
        ];
    }

    public function publish(): void
    {
        if (empty($this->messages)) {
            return;
        }

        $this->logger->notice('--- Publishing async events to RabbitMQ ---');
        foreach ($this->messages as $message) {
            $this->bus->dispatch($message);
        }
    }
}

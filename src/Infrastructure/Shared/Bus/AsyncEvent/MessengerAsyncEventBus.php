<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Bus\AsyncEvent;

use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Broadway\Domain\DomainMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerAsyncEventBus
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;
    private LoggerInterface $logger;

    public function __construct(
        MessageBusInterface $messageBus,
        LoggerInterface $logger
    ) {
        $this->messageBus = $messageBus;
        $this->logger = $logger;
    }

    public function dispatch(DomainMessage $command): void
    {
        try {
            $this->logger->notice('  -- Event published => ' . $command->getType() . ' --');
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $error) {
            $this->throwException($error);
        }
    }
}

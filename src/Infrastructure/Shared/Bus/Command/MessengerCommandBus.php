<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Bus\Command;

use App\Application\Command\Shared\CommandBusInterface;
use App\Application\Command\Shared\CommandInterface;
use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

final class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    public function __construct(
        private MessageBusInterface $messageBus
    ) {}

    /**
     * @throws Throwable
     */
    public function dispatch(CommandInterface $command): void
    {
        try {
            $this->messageBus->dispatch($command);
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}

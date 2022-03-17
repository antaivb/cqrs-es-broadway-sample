<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller;

use App\Application\Command\Shared\CommandBusInterface;
use App\Application\Command\Shared\CommandInterface;
use Throwable;

abstract class CommandController
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws Throwable
     */
    protected function handle(CommandInterface $command): void
    {
        $this->commandBus->handle($command);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Command\Shared;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}

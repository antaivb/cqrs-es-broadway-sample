<?php

declare(strict_types=1);

namespace App\Ports\Cli;

use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\ProcessManager\Replayer;
use Broadway\EventStore\Dbal\DBALEventStore;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RestoreUserCommand extends Command
{
    private DBALEventStore $eventStoreManagement;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        DBALEventStore $eventStoreManagement,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct();
        $this->eventStoreManagement = $eventStoreManagement;
        $this->userRepository = $userRepository;
    }

    protected function configure(): void
    {
        $this->setName('restore:users');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $replayer = new Replayer($this->eventStoreManagement, $this->userRepository);
        $replayer->replayForEvent([UserWasCreated::class]);

        return Command::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace App\Ports\Cli;

use App\Domain\User\Model\User;
use App\Infrastructure\Shared\ProcessManager\AbstractCreatorDomainEvents;
use App\Infrastructure\User\ProcessManager\UserCreateDomainEvents;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDomainEventsCommand extends Command
{
    public function __construct(
        private UserCreateDomainEvents $userCreateDomainEvents
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('domain:events:create');
        $this->setDescription("Process to create event domain");
        $this->addOption('class', null, InputOption::VALUE_REQUIRED, 'Class to create events');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $modelClass = $input->getOption('class');

        $createDomainEvent = $this->getProcessManagerInstance($modelClass);
        if (!$createDomainEvent) {
            $output->writeln("Unknown class or not existent Domain Event");
        }

        $numElements = 0;
        $rows = $createDomainEvent->getElements();
        foreach ($rows as $row) {
            $existEvent = $createDomainEvent->existEventSpecification($row->id()->toString());
            if ($existEvent) {
                continue;
            }

            $response = $createDomainEvent->recreate($row);
            $createDomainEvent->save($response);
            $numElements++;
        }

        $output->writeln("Number of events created (" . $modelClass . " class): " . $numElements);
        return Command::SUCCESS;
    }

    private function getProcessManagerInstance(string $modelClass): ?AbstractCreatorDomainEvents
    {
        return match ($modelClass) {
            User::class => $this->userCreateDomainEvents,
            default => null,
        };
    }
}
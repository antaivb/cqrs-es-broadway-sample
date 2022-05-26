<?php

declare(strict_types=1);

namespace App\Application\Command\Session\Create;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\Session\Model\Session;
use App\Domain\Session\Model\ValueObject\NumBookings;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\StatusFactory;
use App\Domain\Session\Repository\SessionStoreRepositoryInterface;
use App\Domain\Session\Specification\UniqueSessionSpecificationInterface;
use App\Domain\Shared\ValueObject\UpdatedAt;

final class CreateSessionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private SessionStoreRepositoryInterface $sessionStoreRepository,
        private UniqueSessionSpecificationInterface $uniqueSessionSpecification
    ) {}

    public function __invoke(CreateSessionCommand $command): void
    {
        $session = Session::create(
            SessionId::generate(),
            $command->when(),
            $command->duration(),
            $command->meeting(),
            StatusFactory::makeEnabled(),
            UpdatedAt::empty(),
            $command->maxParticipants(),
            NumBookings::initialize(),
            $this->uniqueSessionSpecification
        );

        $this->sessionStoreRepository->store($session);
    }
}

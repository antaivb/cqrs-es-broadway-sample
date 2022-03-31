<?php

declare(strict_types=1);

namespace App\Application\Command\Session\Create;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\Session\Model\Session;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\StatusFactory;
use App\Domain\Session\Repository\SessionStoreRepositoryInterface;
use App\Domain\Session\Specification\UniqueSessionSpecificationInterface;

final class CreateSessionCommandHandler implements CommandHandlerInterface
{
    private SessionStoreRepositoryInterface $sessionStoreRepository;
    private UniqueSessionSpecificationInterface $uniqueSessionSpecification;

    public function __construct(
        SessionStoreRepositoryInterface $sessionStoreRepository,
        UniqueSessionSpecificationInterface $uniqueSessionSpecification
    ) {
        $this->sessionStoreRepository = $sessionStoreRepository;
        $this->uniqueSessionSpecification = $uniqueSessionSpecification;
    }

    public function __invoke(CreateSessionCommand $command): void
    {
        $session = Session::create(
            SessionId::generate(),
            $command->when(),
            $command->duration(),
            $command->meeting(),
            StatusFactory::makeEnabled(),
            $command->vilmaClassId(),
            null,
            $command->maxParticipants(),
            $this->uniqueSessionSpecification
        );

        $this->sessionStoreRepository->store($session);
    }
}

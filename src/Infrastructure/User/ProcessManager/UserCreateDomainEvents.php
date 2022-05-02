<?php

namespace App\Infrastructure\User\ProcessManager;

use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\ExistUserSpecificationInterface;
use App\Infrastructure\Shared\ProcessManager\AbstractCreatorDomainEvents;
use Broadway\EventStore\EventStore;

class UserCreateDomainEvents extends AbstractCreatorDomainEvents
{
    public function __construct(
        protected EventStore $eventStore,
        private UserRepositoryInterface $userRepository,
        private ExistUserSpecificationInterface $existUserSpecification
    ) {}

    public function getElements(): ?array
    {
        return $this->userRepository->findAll();
    }

    public function recreate($row): User
    {
        return User::recreate(
            $row->id(),
            $row->name(),
            new Credentials($row->email(), $row->hashedPassword()),
            $this->existUserSpecification
        );
    }
}
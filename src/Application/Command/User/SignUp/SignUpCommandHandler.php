<?php

declare(strict_types=1);

namespace App\Application\Command\User\SignUp;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;

final class SignUpCommandHandler implements CommandHandlerInterface
{
    private UserStoreRepositoryInterface $userStoreRepository;
    private UniqueEmailSpecificationInterface $uniqueEmailSpecification;

    public function __construct(
        UniqueEmailSpecificationInterface $uniqueEmailSpecification,
        UserStoreRepositoryInterface $userStoreRepository
    ) {
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->userStoreRepository = $userStoreRepository;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = User::create(
            UserId::generate(),
            $command->name(),
            $command->credentials(),
            $this->uniqueEmailSpecification
        );

        $this->userStoreRepository->store($user);
    }
}

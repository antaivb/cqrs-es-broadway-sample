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
        $user = $this->userStoreRepository->get(UserId::fromString('97002b63-8e02-4e1d-a71f-5b0896880f3e'));
        var_dump($user);
        die;

        $user = User::create(
            UserId::generate(),
            $command->name(),
            $command->credentials(),
            $this->uniqueEmailSpecification
        );

        $this->userStoreRepository->store($user);
    }
}

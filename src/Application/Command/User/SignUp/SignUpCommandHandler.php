<?php

declare(strict_types=1);

namespace App\Application\Command\User\SignUp;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;

final class SignUpCommandHandler implements CommandHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private UniqueEmailSpecificationInterface $uniqueEmailSpecification;

    public function __construct(
        UniqueEmailSpecificationInterface $uniqueEmailSpecification,
        UserRepositoryInterface $userRepository
    ) {
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->userRepository = $userRepository;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $user = User::create(
            UserId::generate(),
            $command->getName(),
            $command->getCredentials(),
            $this->uniqueEmailSpecification
        );

        $this->userRepository->save($user);
    }
}

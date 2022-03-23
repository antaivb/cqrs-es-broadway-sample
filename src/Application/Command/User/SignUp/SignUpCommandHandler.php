<?php

declare(strict_types=1);

namespace App\Application\Command\User\SignUp;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;
use Psr\Log\LoggerInterface;

final class SignUpCommandHandler implements CommandHandlerInterface
{
    private UserStoreRepositoryInterface $userStoreRepository;
    private UniqueEmailSpecificationInterface $uniqueEmailSpecification;
    private LoggerInterface $logger;

    public function __construct(
        UniqueEmailSpecificationInterface $uniqueEmailSpecification,
        UserStoreRepositoryInterface $userStoreRepository,
        LoggerInterface $logger
    ) {
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->userStoreRepository = $userStoreRepository;
        $this->logger = $logger;
    }

    public function __invoke(SignUpCommand $command): void
    {
        $this->logger->critical('SignUpCommand');

        $user = User::create(
            UserId::generate(),
            $command->name(),
            $command->credentials(),
            $this->uniqueEmailSpecification
        );

        $this->userStoreRepository->store($user);
    }
}

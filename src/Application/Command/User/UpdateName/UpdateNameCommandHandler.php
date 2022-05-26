<?php

declare(strict_types=1);

namespace App\Application\Command\User\UpdateName;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\User\Repository\UserStoreRepositoryInterface;

final class UpdateNameCommandHandler implements CommandHandlerInterface
{
    private UserStoreRepositoryInterface $userStoreRepository;

    public function __construct(
        UserStoreRepositoryInterface $userStoreRepository
    ) {
        $this->userStoreRepository = $userStoreRepository;
    }

    public function __invoke(UpdateNameCommand $command): void
    {
        $user = $this->userStoreRepository->get($command->id());
        $user->updateName($command->name());

        $this->userStoreRepository->store($user);
    }
}

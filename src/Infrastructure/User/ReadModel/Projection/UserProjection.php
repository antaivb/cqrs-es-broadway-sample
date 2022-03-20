<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ReadModel\Projection;

use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\ReadModel\UserView;
use Broadway\ReadModel\Projector;

final class UserProjection extends Projector
{
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    protected function applyUserWasCreated(UserWasCreated $userWasCreated): void
    {
        $userReadModel = UserView::fromSerializable($userWasCreated);

        $this->userRepository->save($userReadModel);
    }
}

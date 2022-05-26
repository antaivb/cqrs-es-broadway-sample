<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ReadModel\Projection;

use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\User\ReadModel\UserView;
use Broadway\ReadModel\Projector;

final class UserProjection extends Projector
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    protected function applyUserWasCreated(UserWasCreated $userWasCreated): void
    {
        $userReadModel = UserView::fromSerializable($userWasCreated);

        $this->userRepository->save($userReadModel);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ReadModel\Repository;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Shared\Persistence\DoctrineRepository;
use App\Infrastructure\User\ReadModel\UserView;

class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    public function save(UserView $user): void
    {
        $this->persist($user);
    }

    public function findByEmail(string $userEmail): ?UserView
    {
        $userRepository = $this->repository(UserView::class);
        return $userRepository->findOneBy(['email' => $userEmail]);
    }
}

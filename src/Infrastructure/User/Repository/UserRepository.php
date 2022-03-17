<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Shared\Persistence\DoctrineRepository;

class UserRepository extends DoctrineRepository implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function findByEmail(string $userEmail): ?User
    {
        $userRepository = $this->repository(User::class);
        return $userRepository->findOneBy(['email' => $userEmail]);
    }
}

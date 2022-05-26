<?php

namespace App\Domain\User\Repository;

use App\Infrastructure\User\ReadModel\UserView;

interface UserRepositoryInterface
{
    public function save(UserView $user): void;

    public function findByEmail(string $userEmail): ?UserView;

    public function findById(string $id): ?UserView;

    public function findAll(): ?array;
}

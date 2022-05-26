<?php



namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;

interface UserStoreRepositoryInterface
{
    public function store(User $user): void;

    public function get(UserId $id): User;
}

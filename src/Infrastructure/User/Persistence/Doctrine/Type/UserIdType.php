<?php

namespace App\Infrastructure\User\Persistence\Doctrine\Type;

use App\Domain\User\Model\ValueObject\UserId;
use App\Infrastructure\Shared\Persistence\Doctrine\Type\AbstractUidType;

final class UserIdType extends AbstractUidType
{
    const USER_ID = 'user_id';
    protected function getUidClass(): string
    {
        return UserId::class;
    }

    public function getName(): string
    {
        return self::USER_ID;
    }
}

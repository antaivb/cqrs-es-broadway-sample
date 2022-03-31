<?php

namespace App\Infrastructure\Session\Persistence\Doctrine\Type;

use App\Domain\Session\Model\ValueObject\SessionId;
use App\Infrastructure\Shared\Persistence\Doctrine\Type\AbstractUidType;

final class SessionIdType extends AbstractUidType
{
    const SESSION_ID = 'session_id';
    protected function getUidClass(): string
    {
        return SessionId::class;
    }

    public function getName(): string
    {
        return self::SESSION_ID;
    }
}

<?php

namespace App\Domain\User\Model\ValueObject;

use App\Domain\Shared\ValueObject\AggregateRootId;
use Assert\Assertion;
use Ramsey\Uuid\Uuid;

final class UserId extends AggregateRootId implements \JsonSerializable
{
    public static function generate(): self
    {
        $id = new self(Uuid::uuid4()->toString());

        return $id;
    }

    public static function fromString(string $id): self
    {
        Assertion::uuid($id, 'Not a valid uuid');

        $id = new self($id);

        return $id;
    }
}

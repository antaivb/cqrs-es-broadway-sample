<?php

namespace App\Domain\Booking\Model\ValueObject;

use App\Domain\Shared\ValueObject\AggregateRootId;
use Ramsey\Uuid\Uuid;

final class BookingId extends AggregateRootId implements \JsonSerializable
{
    public static function generate(): self
    {
        $id = new self(Uuid::uuid4()->toString());

        return $id;
    }

    public static function fromString(string $id): self
    {
        $id = new self($id);

        return $id;
    }
}

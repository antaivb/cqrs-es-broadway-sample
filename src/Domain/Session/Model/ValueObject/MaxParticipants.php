<?php

declare(strict_types=1);

namespace App\Domain\Session\Model\ValueObject;

use Assert\Assertion;

class MaxParticipants implements \JsonSerializable
{
    private int $maxParticipants;

    protected function __construct(int $maxParticipants)
    {
        $this->maxParticipants = $maxParticipants;
    }

    public static function fromInt(int $maxParticipants): self
    {
        Assertion::numeric($maxParticipants, 'Not valid maxParticipants');

        return new self($maxParticipants);
    }

    public function toInteger(): int
    {
        return $this->maxParticipants;
    }

    public function jsonSerialize(): int
    {
        return $this->toInteger();
    }
}

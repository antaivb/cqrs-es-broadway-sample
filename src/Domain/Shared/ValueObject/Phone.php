<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;

class Phone implements \JsonSerializable
{
    public const MAX_LENGTH = 10;
    private ?string $phone = null;

    public static function fromString(string $phone): self
    {
        Assertion::notNull($phone, 'Not a valid phone');

        $self = new self();
        $self->phone = $phone;

        return $self;
    }

    public static function empty(): self
    {
        $self = new self();

        return $self;
    }

    public function toString(): ?string
    {
        return $this->phone;
    }

    public function __toString(): string
    {
        return $this->phone;
    }

    public function jsonSerialize(): ?string
    {
        return $this->toString();
    }
}


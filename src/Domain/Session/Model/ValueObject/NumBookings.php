<?php

declare(strict_types=1);

namespace App\Domain\Session\Model\ValueObject;

use Assert\Assertion;

class NumBookings implements \JsonSerializable
{
    private int $numBookings;

    protected function __construct(int $numBookings)
    {
        $this->numBookings = $numBookings;
    }

    public static function fromInt(int $numBookings): self
    {
        Assertion::numeric($numBookings, 'Not valid numBookings');

        return new self($numBookings);
    }

    public static function initialize(): self
    {
        return new self(0);
    }

    public function toInteger(): int
    {
        return $this->numBookings;
    }

    public function jsonSerialize(): int
    {
        return $this->toInteger();
    }

    public function increment(): int
    {
        return ++$this->numBookings;
    }
}

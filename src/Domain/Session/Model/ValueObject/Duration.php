<?php

declare(strict_types=1);

namespace App\Domain\Session\Model\ValueObject;

use Assert\Assertion;

class Duration implements \JsonSerializable
{
    private int $duration;

    protected function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public static function fromInt(int $duration): self
    {
        Assertion::numeric($duration, 'Not valid duration');

        return new self($duration);
    }

    public function toInteger(): int
    {
        return $this->duration;
    }

    public function jsonSerialize(): int
    {
        return $this->toInteger();
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use JetBrains\PhpStorm\Pure;

class Lastname implements \JsonSerializable
{
    public const MAX_LENGTH = 2000;

    private string $lastname;

    protected function __construct(string $lastname)
    {
        $this->lastname = $lastname;
    }

    public static function fromString(string $lastname): self
    {
        Assertion::notNull($lastname, 'Not a valid lastname');

        return new self($lastname);
    }

    public function toString(): string
    {
        return $this->lastname;
    }

    #[Pure] public function __toString(): string
    {
        return $this->toString();
    }

    #[Pure] public function jsonSerialize(): string
    {
        return $this->toString();
    }

}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

class Name implements \JsonSerializable
{
    public const MAX_LENGTH = 2000;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $name): self
    {
        Assertion::notNull($name, 'Not a valid name');

        return new self($name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

}

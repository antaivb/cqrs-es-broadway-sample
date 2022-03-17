<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;

abstract class AggregateRootId
{
    protected string $id;

    public function __construct(string $id)
    {
        Assertion::uuid($id, 'This is not valid uuid');
        $this->id = $id;
    }

    public function getValue(): string
    {
        return $this->id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use JetBrains\PhpStorm\Pure;

abstract class AggregateRootId
{
    protected string $id;

    protected function __construct(string $id)
    {
        Assertion::uuid($id, 'This is not valid uuid');
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
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

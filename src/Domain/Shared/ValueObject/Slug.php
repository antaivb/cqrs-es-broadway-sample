<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;
use App\Domain\Shared\Utils;

class Slug implements \JsonSerializable
{
    private string $slug;

    private function __construct(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $slug): self
    {
        Assertion::string($slug);

        return new self(Utils::toSnakeCase(trim($slug)));
    }

    public function toString(): string
    {
        return $this->slug;
    }

    public function __toString(): string
    {
        return $this->slug;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}

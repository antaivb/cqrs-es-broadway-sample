<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;

class UpdatedAt implements \JsonSerializable
{
    private ?\DateTime $updatedAt = null;

    public const FORMAT = 'Y-m-d H:i:s';

    protected function __construct() {}

    public static function fromString(string $date): self
    {
        Assertion::date($date,  self::FORMAT, 'Not a valid date');

        $updatedAt = new self();
        $updatedAt->updatedAt = new \DateTime($date);

        return $updatedAt;
    }

    public static function empty(): self
    {
        return new self();
    }


    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        $updatedAt = new self();
        $updatedAt->updatedAt = new \DateTime($date);

        return $updatedAt;
    }

    public function format(string $format): string
    {
        return $this->updatedAt->format($format);
    }

    public function toString(): ?string
    {
        return ($this->updatedAt) ? $this->updatedAt->format(self::FORMAT) : null;
    }

    public function __toString(): string
    {
        return ($this->updatedAt) ? $this->updatedAt->format(self::FORMAT) : '';
    }

    public function jsonSerialize(): ?string
    {
        return $this->toString();
    }

    public static function generate(): self
    {
        $updatedAt = new self();
        $updatedAt->updatedAt = new \DateTime();

        return $updatedAt;
    }
}

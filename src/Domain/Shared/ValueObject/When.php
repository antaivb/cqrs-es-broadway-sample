<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;

class When implements \JsonSerializable
{
    private \DateTime $when;

    public const FORMAT = 'Y-m-d H:i:s';

    protected function __construct(\DateTime $when)
    {
        $this->when = $when;
    }

    public static function fromString(string $date): self
    {
        Assertion::date($date, self::FORMAT, 'Not a valid date');

        return new self(new \DateTime($date));
    }

    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        return new self(new \DateTime($date));
    }

    public function format(string $format): string
    {
        return $this->when->format($format);
    }

    public function toString(): string
    {
        return $this->when->format(self::FORMAT);
    }

    public function __toString(): string
    {
        return $this->when->format(self::FORMAT);
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    public static function generate(): self
    {
        return new self(new \DateTime());
    }
}

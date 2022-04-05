<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use DateTime;

class When implements \JsonSerializable
{
    private DateTime $when;

    public const FORMAT = 'Y-m-d H:i:s';
    protected function __construct() {}

    public function toString(): string
    {
        return $this->when->format(self::FORMAT);
    }

    public function format(string $format): string
    {
        return $this->when->format($format);
    }

    public static function fromString(string $date): self
    {
        return self::fromFormat($date, self::FORMAT);
    }

    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        $datetime = new self();
        $datetime->when = new DateTime($date);

        return $datetime;
    }

    public static function generate(): self
    {
        $datetime = new self();
        $datetime->when = new DateTime();

        return $datetime;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}

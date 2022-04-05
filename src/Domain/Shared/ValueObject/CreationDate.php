<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use DateTime;

class CreationDate implements \JsonSerializable
{
    private DateTime $creationDate;

    public const FORMAT = 'Y-m-d H:i:s';
    protected function __construct() {}

    public function toString(): string
    {
        return $this->creationDate->format(self::FORMAT);
    }

    public function format(string $format): string
    {
        return $this->creationDate->format($format);
    }

    public static function fromString(string $date): self
    {
        return self::fromFormat($date, self::FORMAT);
    }

    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        $datetime = new self();
        $datetime->creationDate = new DateTime($date);

        return $datetime;
    }

    public static function generate(): self
    {
        $datetime = new self();
        $datetime->creationDate = new DateTime();

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
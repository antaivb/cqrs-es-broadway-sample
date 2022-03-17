<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;

class CreationDate implements \JsonSerializable
{
    private \DateTime $creationDate;

    public const FORMAT = 'Y-m-d H:i:s';

    public function __construct(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromString(string $date): self
    {
        Assertion::date($date,  self::FORMAT, 'Not a valid date');

        return new self(new \DateTime($date));
    }

    /**
     * @throws AssertionFailedException
     */
    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        return new self(new \DateTime($date));
    }

    public function format(string $format): string
    {
        return $this->creationDate->format($format);
    }

    public function toString(): string
    {
        return $this->creationDate->format(self::FORMAT);
    }

    public function __toString(): string
    {
        return $this->creationDate->format(self::FORMAT);
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

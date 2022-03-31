<?php

declare(strict_types=1);

namespace App\Domain\Booking\Model\ValueObject;

use Assert\Assertion;

class UnsubscribedAt implements \JsonSerializable
{
    private ?\DateTimeInterface $unsubscribedAt = null;

    public const FORMAT = 'Y-m-d H:i:s';

    protected function __construct() {}

    public static function empty(): self
    {
        return new self();
    }

    public static function fromString(?string $date): self
    {
        $unsubscribedAt = new self();

        if (!empty($date)) {
            $unsubscribedAt->unsubscribedAt = new \DateTime($date);
        }

        return $unsubscribedAt;
    }

    public function unsubscribedAt(): ?\DateTimeInterface
    {
        return $this->unsubscribedAt;
    }

    public static function fromFormat(string $date, string $format): self
    {
        Assertion::date($date, $format, 'Not a valid date');

        $unsubscribedAt = new self();
        $unsubscribedAt->unsubscribedAt = new \DateTime($date);

        return $unsubscribedAt;
    }

    public function format(string $format): ?string
    {
        return ($this->unsubscribedAt) ? $this->unsubscribedAt->format($format) : null;
    }

    public function toString(): string
    {
        return (!empty($this->unsubscribedAt)) ? $this->unsubscribedAt->format(self::FORMAT) : '';
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }

    public static function generate(): self
    {
        $unsubscribedAt = new self();
        $unsubscribedAt->unsubscribedAt = new \DateTime();

        return $unsubscribedAt;
    }
}

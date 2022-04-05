<?php

namespace App\Domain\Session\Model\ValueObject\Status;

use Assert\Assertion;
use Assert\AssertionFailedException;
use JetBrains\PhpStorm\Pure;

class Status implements \JsonSerializable
{
    private int $status;

    const ALLOWED_STATUSES = [
        'PENDING' => 0,
        'ENABLED' => 1,
        'DISABLED' => 2
    ];

    protected function __construct() {}

    public static function fromInt(int $statusValue): self
    {
        try {
            Assertion::inArray($statusValue, self::ALLOWED_STATUSES);
        } catch (AssertionFailedException $e) {
            throw new StatusNotAllowedException();
        }

        $status = new self();
        $status->status = $statusValue;

        return $status;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function toInteger(): int
    {
        return $this->status;
    }

    public function isEnabled(): bool
    {
        return $this->status == self::ALLOWED_STATUSES['ENABLED'];
    }

    public function isPending(): bool
    {
        return $this->status == self::ALLOWED_STATUSES['PENDING'];
    }

    public function isDisabled(): bool
    {
        return $this->status == self::ALLOWED_STATUSES['DISABLED'];
    }

    #[Pure] public function jsonSerialize(): int
    {
        return $this->toInteger();
    }
}
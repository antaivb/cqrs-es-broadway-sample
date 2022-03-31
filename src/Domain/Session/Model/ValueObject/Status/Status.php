<?php

namespace App\Domain\Session\Model\ValueObject\Status;

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
        $status = new self();
        $status->setStatus($statusValue);

        return $status;
    }

    public function status(): int
    {
        return $this->status;
    }

    private function setStatus(int $status): void
    {
        if (!in_array($status, self::ALLOWED_STATUSES)) {
            throw new StatusNotAllowedException();
        }

        $this->status = $status;
    }

    public function toInt(): int
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
        return $this->toInt();
    }
}
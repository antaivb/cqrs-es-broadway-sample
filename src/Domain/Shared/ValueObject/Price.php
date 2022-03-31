<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidPriceException;

class Price
{
    private Money $money;

    protected function __construct() {}

    public static function fromString(float $amount, string $iso): self
    {
        $price = new self();
        $money = Money::fromString($amount, $iso);
        $price->setMoney($money);

        return $price;
    }

    public function money(): Money
    {
        return $this->money;
    }

    private function setMoney(Money $money): void
    {
        if ($money->amount() < 0) {
            throw new InvalidPriceException();
        }

        $this->money = $money;
    }

    public function isFree(): bool
    {
        return $this->money->amount() == 0;
    }

    public function equals(Price $price): bool
    {
        return $this->money->equals($price->money());
    }
}
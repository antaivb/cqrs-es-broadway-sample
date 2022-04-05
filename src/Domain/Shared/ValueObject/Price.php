<?php

namespace App\Domain\Shared\ValueObject;

use JetBrains\PhpStorm\Pure;

class Price
{
    private Money $money;

    protected function __construct() {}

    public static function fromString(float $amount, string $iso): self
    {
        $price = new self();
        $price->money = Money::fromString($amount, $iso);

        return $price;
    }

    #[Pure] public function isFree(): bool
    {
        return $this->money->amount() == 0;
    }

    #[Pure] public function equals(Price $price): bool
    {
        return $this->money->equals($price->money);
    }
}
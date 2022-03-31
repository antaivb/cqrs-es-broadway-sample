<?php

namespace App\Domain\Shared\ValueObject;

use JetBrains\PhpStorm\Pure;

class Money
{
    private float $amount;
    private string $isoCode;
    # private Currency $currency;

    protected function __construct(float $amount, string $isoCode)
    {
        $this->amount = $amount;
        $this->isoCode = $isoCode;
        # $this->currency = $currency;
    }

    public static function fromString(float $amount, string $iso): self
    {
        return new self($amount, $iso);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function isoCode(): string
    {
        return $this->isoCode;
    }

    /*
    public function currency(): Currency
    {
        return $this->currency;
    }
    */

    #[Pure] public function equals(Money $money): bool
    {
        return $this->amount == $money->amount
            && $this->isoCode = $money->isoCode;
    }
}
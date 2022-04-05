<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidPriceException;
use Assert\Assertion;
use Assert\AssertionFailedException;

class Money
{
    private float $amount;
    private string $isoCode;
    # private Currency $currency;

    protected function __construct() {}

    public static function fromString(float $amount, string $iso): self
    {
        try {
            Assertion::integer($amount);
            Assertion::min($amount, 1);
        } catch (AssertionFailedException $e) {
            throw new InvalidPriceException();
        }

        Assertion::inArray($iso, Currency::ALLOWED_CURRENCIES);

        $money = new self();
        $money->amount = $amount;
        $money->isoCode = $iso;

        return $money;
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

    public function equals(Money $money): bool
    {
        return $this->amount == $money->amount
            && $this->isoCode = $money->isoCode;
    }
}
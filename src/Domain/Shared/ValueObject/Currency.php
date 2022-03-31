<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\InvalidCurrencyIsoCodeFormatException;
use App\Domain\Shared\Exception\NotAllowedCurrencyException;
use JetBrains\PhpStorm\Pure;

class Currency implements \JsonSerializable
{
    private string $isoCode;
    const ALLOWED_CURRENCIES = [
        'EUR',
    ];

    protected function __construct() {}

    public static function fromString(string $isoCode)
    {
        $currency = new self();
        $currency->setIsoCode($isoCode);

        return $currency;
    }

    public function isoCode(): string
    {
        return $this->isoCode;
    }

    private function setIsoCode(string $isoCode): void
    {
        if (!preg_match('/^[A-Z]{3}$/', $isoCode)) {
            throw new InvalidCurrencyIsoCodeFormatException();
        }

        if (!in_array($isoCode, self::ALLOWED_CURRENCIES)) {
            throw new NotAllowedCurrencyException();
        }

        $this->isoCode = $isoCode;
    }

    public function equals(Currency $currency): bool
    {
        return $this->isoCode == $currency->isoCode;
    }

    public function toString(): string
    {
        return $this->isoCode;
    }

    public function __toString(): string
    {
        return $this->isoCode;
    }

    #[Pure] public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
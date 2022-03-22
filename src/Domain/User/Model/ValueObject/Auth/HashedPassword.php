<?php

declare(strict_types=1);

namespace App\Domain\User\Model\ValueObject\Auth;

use Assert\Assertion;
use const PASSWORD_BCRYPT;
use RuntimeException;

class HashedPassword
{
    private string $hashedPassword;
    private ?string $requestPasswordRecoverySalt;

    public const COST = 12;
    public const MIN_CHARACTERS = 6;

    protected function __construct(string $hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    public static function encode(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function requestPasswordRecoverySalt(string $value): self
    {
        $salt = md5(uniqid($value, true));;
        $this->requestPasswordRecoverySalt = $salt;
        return $this;
    }

    public function match(string $plainPassword): bool
    {
        if (self::isTestSuite()) {
            return $this->hashedPassword === $plainPassword;
        }

        return \password_verify($plainPassword, $this->hashedPassword);
    }

    private static function hash(string $plainPassword): string
    {
        Assertion::minLength($plainPassword, self::MIN_CHARACTERS, 'Minimo 6 caracteres en la contraseña');

        if (self::isTestSuite()) {
            return $plainPassword;
        }

        /** @var string|bool|null $hashedPassword */
        $hashedPassword = \password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (\is_bool($hashedPassword)) {
            throw new RuntimeException('Server error hashing password');
        }

        return (string) $hashedPassword;
    }

    public function toString(): string
    {
        return $this->hashedPassword;
    }

    public function toStringRequestPasswordRecoverySalt(): string
    {
        return $this->requestPasswordRecoverySalt;
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }

    private static function isTestSuite(): bool
    {
        return $_SERVER['APP_ENV'] === 'test';
    }
}

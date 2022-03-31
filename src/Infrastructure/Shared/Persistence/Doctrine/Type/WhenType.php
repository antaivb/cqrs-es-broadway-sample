<?php

namespace App\Infrastructure\Shared\Persistence\Doctrine\Type;

use App\Domain\Shared\ValueObject\When;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class WhenType extends Type
{
    const WHEN = 'when';

    protected function getUidClass(): string
    {
        return When::class;
    }

    public function getName(): string
    {
        return self::WHEN;
    }

    /**
     * Adds an SQL comment to typehint the actual Doctrine Type for reverse schema engineering.
     */
    final public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }

    /**
     * Converts a value from its database representation to its PHP representation of this type.
     *
     * @param mixed $value The value to convert.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?When
    {
        return $value !== null ? When::fromFormat($value, When::FORMAT) : null;
    }

    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param When|null $value The value to convert.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return $value?->format($platform->getDateFormatString());
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     */
    final public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }
}

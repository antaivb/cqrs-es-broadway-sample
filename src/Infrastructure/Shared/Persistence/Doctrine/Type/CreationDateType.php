<?php

namespace App\Infrastructure\Shared\Persistence\Doctrine\Type;

use App\Domain\Shared\ValueObject\CreationDate;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class CreationDateType extends Type
{
    const CREATION_DATE = 'creation_date';

    protected function getUidClass(): string
    {
        return CreationDate::class;
    }

    public function getName(): string
    {
        return self::CREATION_DATE;
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
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?CreationDate
    {
        return $value !== null ? CreationDate::fromFormat($value, CreationDate::FORMAT) : null;
    }


    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param CreationDate|null $value The value to convert.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return $value ? $value->format($platform->getDateFormatString()) : null;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     */
    final public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }
}

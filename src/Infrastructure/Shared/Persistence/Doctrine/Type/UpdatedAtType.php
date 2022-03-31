<?php

namespace App\Infrastructure\Shared\Persistence\Doctrine\Type;

use App\Domain\Shared\ValueObject\UpdatedAt;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class UpdatedAtType extends Type
{
    const UPDATED_AT = 'updated_at';

    protected function getUidClass(): string
    {
        return UpdatedAt::class;
    }

    public function getName(): string
    {
        return self::UPDATED_AT;
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
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?UpdatedAt
    {
        return $value !== null ? UpdatedAt::fromFormat($value, UpdatedAt::FORMAT) : null;
    }


    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param UpdatedAt|null $value The value to convert.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return ($value->toString()) ? $value->format($platform->getDateFormatString()) : null;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     */
    final public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getDateTimeTypeDeclarationSQL($column);
    }
}

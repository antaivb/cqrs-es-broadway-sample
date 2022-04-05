<?php

namespace App\Infrastructure\Session\Persistence\Doctrine\Type;

use App\Domain\Session\Model\ValueObject\Status\Status;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class StatusType extends Type
{
    const NAME = 'status';

    protected function getUidClass(): string
    {
        return Status::class;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     */
    final public function getSQLDeclaration(array $column, AbstractPlatform $platform) : string
    {
        return $platform->getIntegerTypeDeclarationSQL([]);
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
    public function convertToPHPValue($value, AbstractPlatform $platform) : ?Status
    {
        return $value !== null ? Status::fromInt((int)$value) : null;
    }


    /**
     * Converts a value from its PHP representation to its database representation of this type.
     *
     * @param Status|null $value The value to convert.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform) : ?string
    {
        return $value?->toInteger();
    }
}

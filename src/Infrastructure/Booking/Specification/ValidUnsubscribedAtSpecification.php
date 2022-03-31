<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\Specification;

use App\Domain\Booking\Exception\InvalidUnsubscribedAtDateException;
use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Booking\Specification\ValidUnsubscribedAtSpecificationInterface;
use App\Domain\Shared\ValueObject\CreationDate;

final class ValidUnsubscribedAtSpecification implements ValidUnsubscribedAtSpecificationInterface
{
    public function isValid(UnsubscribedAt $unsubscribedAt, CreationDate $createdAt): void
    {
        if ($unsubscribedAt < $createdAt) {
            throw new InvalidUnsubscribedAtDateException();
        }
    }
}

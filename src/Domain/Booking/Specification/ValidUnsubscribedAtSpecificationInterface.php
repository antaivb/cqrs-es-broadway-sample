<?php

declare(strict_types=1);

namespace App\Domain\Booking\Specification;

use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Shared\ValueObject\CreationDate;

interface ValidUnsubscribedAtSpecificationInterface
{
    public function isValid(UnsubscribedAt $unsubscribedAt, CreationDate $createdAt): void;
}

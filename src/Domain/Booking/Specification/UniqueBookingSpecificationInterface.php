<?php

declare(strict_types=1);

namespace App\Domain\Booking\Specification;

use App\Domain\Booking\Model\ValueObject\BookingId;

interface UniqueBookingSpecificationInterface
{
    public function isUnique(BookingId $id): void;
}

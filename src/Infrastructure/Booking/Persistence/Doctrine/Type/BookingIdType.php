<?php

namespace App\Infrastructure\Booking\Persistence\Doctrine\Type;


use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Infrastructure\Shared\Persistence\Doctrine\Type\AbstractUidType;

final class BookingIdType extends AbstractUidType
{
    const BOOKING_ID = 'booking_id';
    protected function getUidClass(): string
    {
        return BookingId::class;
    }

    public function getName(): string
    {
        return self::BOOKING_ID;
    }
}

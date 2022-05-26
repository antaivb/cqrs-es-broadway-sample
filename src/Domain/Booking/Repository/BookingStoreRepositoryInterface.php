<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Model\Booking;
use App\Domain\Booking\Model\ValueObject\BookingId;

interface BookingStoreRepositoryInterface
{
    public function store(Booking $booking): void;

    public function get(BookingId $id): Booking;
}

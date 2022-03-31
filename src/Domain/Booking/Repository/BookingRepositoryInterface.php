<?php

namespace App\Domain\Booking\Repository;

use App\Infrastructure\Booking\ReadModel\BookingView;

interface BookingRepositoryInterface
{
    public function insert(BookingView $booking): void;

    public function find(string $id): ?BookingView;
}
<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\ReadModel\Repository;

use App\Domain\Booking\Repository\BookingRepositoryInterface;
use App\Infrastructure\Booking\ReadModel\BookingView;
use App\Infrastructure\Shared\Persistence\DoctrineRepository;

class BookingRepository extends DoctrineRepository implements BookingRepositoryInterface
{
    public function insert(BookingView $booking): void
    {
        $this->persist($booking);
    }

    public function find(string $id): ?BookingView
    {
        $bookingRepository = $this->repository(BookingView::class);
        return $bookingRepository->findOneBy(['id' => $id]);
    }
}

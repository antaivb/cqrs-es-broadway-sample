<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\Specification;

use App\Domain\Booking\Exception\BookingAlreadyExistsException;
use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Repository\BookingRepositoryInterface;
use App\Domain\Booking\Specification\UniqueBookingSpecificationInterface;
use App\Domain\Shared\Specification\AbstractSpecification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class UniqueBookingSpecification extends AbstractSpecification implements UniqueBookingSpecificationInterface
{
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function isUnique(BookingId $id): void
    {
        $this->isSatisfiedBy($id->toString());
    }

    public function isSatisfiedBy($value): void
    {
        try {
            $this->bookingRepository->find($value);
        } catch (NotFoundHttpException $e) {
            throw new BookingAlreadyExistsException();
        }
    }
}

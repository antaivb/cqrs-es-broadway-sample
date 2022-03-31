<?php

declare(strict_types=1);

namespace App\Application\Command\Booking\Create;

use App\Application\Command\Shared\CommandHandlerInterface;
use App\Domain\Booking\Model\Booking;
use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Booking\Repository\BookingStoreRepositoryInterface;
use App\Domain\Booking\Specification\UniqueBookingSpecificationInterface;
use App\Domain\Booking\Specification\ValidUnsubscribedAtSpecificationInterface;
use App\Domain\Session\Specification\ExistSessionSpecificationInterface;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\Price;
use App\Domain\User\Specification\ExistUserSpecificationInterface;

final class CreateBookingCommandHandler implements CommandHandlerInterface
{
    private BookingStoreRepositoryInterface $bookingStoreRepository;
    private ExistUserSpecificationInterface $existUserSpecification;
    private ExistSessionSpecificationInterface $existSessionSpecification;
    private ValidUnsubscribedAtSpecificationInterface $validUnsubscribedAtSpecification;
    private UniqueBookingSpecificationInterface $uniqueBookingSpecification;

    public function __construct(
        BookingStoreRepositoryInterface $bookingStoreRepository,
        ExistUserSpecificationInterface $existUserSpecification,
        ExistSessionSpecificationInterface $existSessionSpecification,
        ValidUnsubscribedAtSpecificationInterface $validUnsubscribedAtSpecification,
        UniqueBookingSpecificationInterface $uniqueBookingSpecification
    ) {
        $this->bookingStoreRepository = $bookingStoreRepository;
        $this->existUserSpecification = $existUserSpecification;
        $this->existSessionSpecification = $existSessionSpecification;
        $this->validUnsubscribedAtSpecification = $validUnsubscribedAtSpecification;
        $this->uniqueBookingSpecification = $uniqueBookingSpecification;
    }

    public function __invoke(CreateBookingCommand $command): void
    {
        $price = Price::fromString(1, 'EUR');

        $booking = Booking::create(
            BookingId::generate(),
            $command->sessionId(),
            $command->userId(),
            CreationDate::generate(),
            $price,
            UnsubscribedAt::empty(),
            $command->sendConfirmation(),
            $this->existUserSpecification,
            $this->uniqueBookingSpecification,
            $this->existSessionSpecification,
            $this->validUnsubscribedAtSpecification
        );

        $this->bookingStoreRepository->store($booking);
    }
}

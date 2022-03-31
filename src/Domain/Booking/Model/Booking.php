<?php

namespace App\Domain\Booking\Model;

use App\Domain\Booking\Event\BookingWasCreated;
use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Booking\Specification\UniqueBookingSpecificationInterface;
use App\Domain\Booking\Specification\ValidUnsubscribedAtSpecificationInterface;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Specification\ExistSessionSpecificationInterface;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\Price;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Specification\ExistUserSpecificationInterface;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use JetBrains\PhpStorm\Pure;

class Booking extends EventSourcedAggregateRoot
{
    private BookingId $id;
    private CreationDate $creationDate;
    private UnsubscribedAt $unsubscribedAt;
    private SessionId $sessionId;
    private UserId $userId;
    private Price $price;
    private bool $sendConfirmation;

    protected function __construct() {}

    public static function create(
        BookingId $id,
        SessionId $sessionId,
        UserId $userId,
        CreationDate $creationDate,
        Price $price,
        UnsubscribedAt $unsubscribedAt,
        bool $sendConfirmation,
        ExistUserSpecificationInterface $existUserSpecification,
        UniqueBookingSpecificationInterface $uniqueBookingSpecification,
        ExistSessionSpecificationInterface $existSessionSpecification,
        ValidUnsubscribedAtSpecificationInterface $validUnsubscribedAtSpecification,
    ): self {
        $uniqueBookingSpecification->isUnique($id);
        $existUserSpecification->exist($userId);
        $existSessionSpecification->exist($sessionId);
        $validUnsubscribedAtSpecification->isValid($unsubscribedAt, $creationDate);

        $booking = new self();
        $booking->apply(BookingWasCreated::withData(
            $id,
            $userId,
            $sessionId,
            $price,
            $creationDate,
            $unsubscribedAt,
            $sendConfirmation
        ));

        return $booking;
    }

    protected function applyBookingWasCreated(BookingWasCreated $bookingWasCreated): void
    {
        $this->id = $bookingWasCreated->id();
        $this->sessionId = $bookingWasCreated->sessionId();
        $this->userId = $bookingWasCreated->userId();
        $this->creationDate = $bookingWasCreated->creationDate();
        $this->price = $bookingWasCreated->price();
        $this->unsubscribedAt = $bookingWasCreated->unsubscribedAt();
        $this->sendConfirmation = $bookingWasCreated->sendConfirmation();
    }

    #[Pure] public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }

    public function id(): BookingId
    {
        return $this->id;
    }

    public function session(): SessionId
    {
        return $this->sessionId;
    }

    public function user(): UserId
    {
        return $this->userId;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function unsubscribedAt(): UnsubscribedAt
    {
        return $this->unsubscribedAt;
    }

    public function sendConfirmation(): bool
    {
        return $this->sendConfirmation;
    }
}
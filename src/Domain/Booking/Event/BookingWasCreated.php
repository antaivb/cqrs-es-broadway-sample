<?php

namespace App\Domain\Booking\Event;

use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Shared\ValueObject\Price;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\Shared\ValueObject\CreationDate;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

final class BookingWasCreated implements Serializable
{
    private BookingId $id;
    private UserId $userId;
    private SessionId $sessionId;
    private CreationDate $creationDate;
    private Price $price;
    private UnsubscribedAt $unsubscribedAt;
    private bool $sendConfirmation;

    protected function __construct() {}

    #[Pure] public static function withData(
        BookingId $id,
        UserId $userId,
        SessionId $sessionId,
        Price $price,
        CreationDate $creationDate,
        UnsubscribedAt $unsubscribedAt,
        bool $sendConfirmation,
    ): self {
        $event = new self();

        $event->id = $id;
        $event->userId = $userId;
        $event->sessionId = $sessionId;
        $event->creationDate = $creationDate;
        $event->price = $price;
        $event->unsubscribedAt = $unsubscribedAt;
        $event->sendConfirmation = $sendConfirmation;

        return $event;
    }

    public function id(): BookingId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function sessionId(): SessionId
    {
        return $this->sessionId;
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

    #[ArrayShape(['id' => "string", 'userId' => "string", 'sessionId' => "string", 'creationDate' => "string", 'amount' => "float", 'isoCode' => "string", 'unsubscribedAt' => "string", 'sendConfirmation' => "bool"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'userId' => $this->userId()->toString(),
            'sessionId' => $this->sessionId()->toString(),
            'creationDate' => $this->creationDate()->toString(),
            'amount' => $this->price()->money()->amount(),
            'isoCode' => $this->price()->money()->isoCode(),
            'unsubscribedAt' => $this->unsubscribedAt()->toString(),
            'sendConfirmation' => $this->sendConfirmation()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            BookingId::fromString($data['id']),
            UserId::fromString($data['userId']),
            SessionId::fromString($data['sessionId']),
            Price::fromString($data['amount'], $data['isoCode']),
            CreationDate::fromString($data['cratedAt']),
            UnsubscribedAt::fromString($data['unsubscribedAt']),
            $data['sendConfirmation']
        );
    }
}
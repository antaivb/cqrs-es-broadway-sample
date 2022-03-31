<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\ReadModel;

use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Model\ValueObject\UnsubscribedAt;
use App\Domain\Shared\ValueObject\Price;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Infrastructure\Session\ReadModel\SessionView;
use App\Infrastructure\User\ReadModel\UserView;
use Broadway\ReadModel\SerializableReadModel;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class BookingView implements SerializableReadModel
{
    private BookingId $id;
    private CreationDate $creationDate;
    private UnsubscribedAt $unsubscribedAt;
    private SessionView $session;
    private UserView $user;
    private Price $price;

    protected function __construct() {}

    #[Pure] public static function withData(
        BookingId $id,
        UserView $user,
        SessionView $session,
        Price $price,
        CreationDate $creationDate,
        UnsubscribedAt $unsubscribedAt,
    ): self {
        $booking = new self();

        $booking->id = $id;
        $booking->user = $user;
        $booking->session = $session;
        $booking->creationDate = $creationDate;
        $booking->price = $price;
        $booking->unsubscribedAt = $unsubscribedAt;

        return $booking;
    }

    public function id(): BookingId
    {
        return $this->id;
    }

    public function session(): SessionView
    {
        return $this->session;
    }

    public function user(): UserView
    {
        return $this->user;
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

    #[ArrayShape(['id' => "string", 'creationDate' => "string", 'user' => "array", 'session' => "array", 'priceAmount' => "float", 'priceIsoCode' => "string", 'unsubscribedAt' => "null|string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'creationDate' => $this->creationDate()->toString(),
            'user' => $this->user()->serialize(),
            'session' => $this->session()->serialize(),
            'priceAmount' => $this->price()->money()->amount(),
            'priceIsoCode' => $this->price()->money()->isoCode(),
            'unsubscribedAt' => $this->unsubscribedAt()->toString()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            BookingId::fromString($data['id']),
            $data['user'],
            $data['session'],
            Price::fromString($data['amount'], $data['isoCode']),
            CreationDate::fromString($data['creationDate']),
            UnsubscribedAt::fromString($data['unsubscribedAt']),
        );
    }

    #[Pure] public function getId(): string
    {
        return $this->id()->toString();
    }
}

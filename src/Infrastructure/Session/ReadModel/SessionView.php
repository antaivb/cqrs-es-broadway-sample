<?php

namespace App\Infrastructure\Session\ReadModel;

use App\Domain\Session\Model\ValueObject\Duration;
use App\Domain\Session\Model\ValueObject\MaxParticipants;
use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Session\Model\ValueObject\NumBookings;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\Status;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\UpdatedAt;
use App\Domain\Shared\ValueObject\When;
use Broadway\ReadModel\SerializableReadModel;
use JetBrains\PhpStorm\Pure;

class SessionView implements SerializableReadModel
{
    private SessionId $id;
    private CreationDate $creationDate;
    private UpdatedAt $updatedAt;
    private When $when;
    private Duration $duration;
    private ?Meeting $meeting;
    private Status $status;
    private MaxParticipants $maxParticipants;
    private NumBookings $numBookings;

    protected function __construct() {}

    #[Pure] public static function withData(
        SessionId $id,
        When $when,
        Duration $duration,
        ?Meeting $meeting,
        Status $status,
        CreationDate $creationDate,
        UpdatedAt $updatedAt,
        MaxParticipants $maxParticipants,
        NumBookings $numBookings
    ): self {
        $session = new self();

        $session->id = $id;
        $session->when = $when;
        $session->duration = $duration;
        $session->meeting = $meeting;
        $session->status = $status;
        $session->creationDate = $creationDate;
        $session->updatedAt = $updatedAt;
        $session->maxParticipants = $maxParticipants;
        $session->numBookings = $numBookings;

        return $session;
    }

    #[Pure] public function getId(): string
    {
        return $this->id->toString();
    }
    public function id(): SessionId
    {
        return $this->id;
    }

    public function when(): When
    {
        return $this->when;
    }

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function duration(): Duration
    {
        return $this->duration;
    }

    public function meeting(): ?Meeting
    {
        return $this->meeting;
    }

    public function status(): Status
    {
        return $this->status;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function maxParticipants(): MaxParticipants
    {
        return $this->maxParticipants;
    }

    public function numBookings(): NumBookings
    {
        return $this->numBookings;
    }

    public function setUpdatedAt(UpdatedAt $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function incrementNumBookings(): void
    {
        $this->numBookings->increment();
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'when' => $this->when()->toString(),
            'duration' => $this->duration(),
            'meetingUrl' => $this->meeting()->url(),
            'meetingHostUrl' => $this->meeting()->hostUrl(),
            'status' => $this->status()->status(),
            'creationDate' => $this->creationDate()->toString(),
            'updatedAt' => $this->updatedAt()->toString(),
            'maxParticipants' => $this->maxParticipants(),
            'numBookings' => $this->numBookings()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            SessionId::fromString($data['id']),
            When::fromString($data['when']),
            $data['duration'],
            Meeting::fromString($data['meetingUrl'], $data['meetingHostUrl']),
            Status::fromInt($data['status']),
            CreationDate::fromString($data['creationDate']),
            UpdatedAt::fromStringOrNull($data['updatedAt']),
            $data['maxParticipants'],
            $data['numBookings']
        );
    }
}
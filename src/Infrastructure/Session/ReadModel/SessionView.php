<?php

namespace App\Infrastructure\Session\ReadModel;

use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\Status;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\UpdatedAt;
use App\Domain\Shared\ValueObject\When;
use App\Domain\VilmaClass\Model\ValueObject\VilmaClassId;
use Broadway\ReadModel\SerializableReadModel;
use JetBrains\PhpStorm\Pure;

class SessionView implements SerializableReadModel
{
    private SessionId $id;
    private CreationDate $creationDate;
    private UpdatedAt $updatedAt;
    private When $when;
    private int $duration;
    private ?Meeting $meeting;
    private Status $status;
    private ?VilmaClassId $vilmaClassId = null;
    private int $maxParticipants;
    private int $numBookings;

    protected function __construct() {}

    #[Pure] public static function withData(
        SessionId $id,
        When $when,
        int $duration,
        ?Meeting $meeting,
        Status $status,
        ?VilmaClassId $vilmaClassId,
        CreationDate $creationDate,
        UpdatedAt $updatedAt,
        int $maxParticipants,
        int $numBookings
    ): self {
        $session = new self();

        $session->id = $id;
        $session->when = $when;
        $session->duration = $duration;
        $session->meeting = $meeting;
        $session->status = $status;
        $session->vilmaClassId = $vilmaClassId;
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

    public function duration(): int
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

    public function vilmaClassId(): ?VilmaClassId
    {
        return $this->vilmaClassId;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function maxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function numBookings(): int
    {
        return $this->numBookings;
    }

    public function setUpdatedAt(UpdatedAt $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function incrementNumBookings(): void
    {
        $this->numBookings += 1;
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
            'vilmaClassId' => (!empty($this->vilmaClassId())) ? $this->vilmaClassId()->toString() : null,
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
            (!empty($data['vilmaClassId'])) ? VilmaClassId::fromString($data['vilmaClassId']) : null,
            CreationDate::fromString($data['creationDate']),
            (!empty($data['updatedAt'])) ? UpdatedAt::fromString($data['updatedAt']) : UpdatedAt::empty(),
            $data['maxParticipants'],
            $data['numBookings']
        );
    }
}
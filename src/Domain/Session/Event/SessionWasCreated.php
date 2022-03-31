<?php

namespace App\Domain\Session\Event;

use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\Status;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\VilmaClass\Model\ValueObject\VilmaClassId;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\Pure;

final class SessionWasCreated implements Serializable
{
    private SessionId $id;
    private ?Meeting $meeting;
    private Status $status;
    private ?VilmaClassId $vilmaClassId;
    private CreationDate $creationDate;
    private \DateTimeInterface $when;
    private ?\DateTimeInterface $updatedAt;
    private int $duration;
    private int $maxParticipants;
    private int $numBookings;

    protected function __construct() {}

    #[Pure] public static function withData(
        SessionId $id,
        \DateTimeInterface $when,
        int $duration,
        ?Meeting $meeting,
        Status $status,
        ?VilmaClassId $vilmaClassId,
        CreationDate $creationDate,
        ?\DateTimeInterface $updatedAt,
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

    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'when' => $this->when()->format('Y-m-d H:i:s'),
            'duration' => $this->duration(),
            'meetingUrl' => $this->meeting()->url(),
            'meetingHostUrl' => $this->meeting()->hostUrl(),
            'status' => $this->status()->status(),
            'vilmaClassId' => $this->vilmaClassId()->toString(),
            'creationDate' => $this->creationDate()->toString(),
            'updatedAt' => (!empty($this->updatedAt())) ? $this->updatedAt()->format('Y-m-d') : null,
            'maxParticipants' => $this->maxParticipants(),
            'numBookings' => $this->numBookings()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            SessionId::fromString($data['id']),
            new \DateTime($data['when']),
            $data['duration'],
            Meeting::fromString($data['meetingUrl'], $data['meetingHostUrl']),
            Status::fromInt($data['status']),
            VilmaClassId::fromString($data['vilmaClassId']),
            CreationDate::fromString($data['creationDate']),
            new \DateTime($data['updatedAt']),
            $data['maxParticipants'],
            $data['numBookings']
        );
    }

    public function id(): SessionId
    {
        return $this->id;
    }

    public function when(): \DateTimeInterface
    {
        return $this->when;
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

    public function updatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function maxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function numBookings(): int
    {
        return $this->numBookings;
    }
}
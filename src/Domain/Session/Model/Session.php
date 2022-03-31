<?php

namespace App\Domain\Session\Model;

use App\Domain\Session\Event\SessionWasCreated;
use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\Status;
use App\Domain\Session\Specification\UniqueSessionSpecificationInterface;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\VilmaClass\Model\ValueObject\VilmaClassId;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use JetBrains\PhpStorm\Pure;

class Session extends EventSourcedAggregateRoot
{
    private SessionId $id;
    private CreationDate $creationDate;
    private ?\DateTimeInterface $updatedAt;
    private \DateTimeInterface $when;
    private int $duration;
    private ?Meeting $meeting;
    private Status $status;
    private ?VilmaClassId $vilmaClassId;
    private int $maxParticipants;
    private int $numBookings;

    protected function __construct() {}

    public static function create(
        SessionId $id,
        \DateTimeInterface $when,
        int $duration,
        ?Meeting $meeting,
        Status $status,
        ?VilmaClassId $vilmaClassId,
        ?\DateTimeInterface $updatedAt,
        int $maxParticipants,
        UniqueSessionSpecificationInterface $uniqueSessionSpecification,
        int $numBookings = 0,
    ): self {
        $uniqueSessionSpecification->isUnique($id);

        $session = new self();
        $session->apply(SessionWasCreated::withData(
            $id,
            $when,
            $duration,
            $meeting,
            $status,
            $vilmaClassId,
            CreationDate::generate(),
            $updatedAt,
            $maxParticipants,
            $numBookings
        ));

        return $session;
    }

    protected function applySessionWasCreated(SessionWasCreated $sessionWasCreated): void
    {
        $this->id = $sessionWasCreated->id();
        $this->when = $sessionWasCreated->when();
        $this->duration = $sessionWasCreated->duration();
        $this->meeting = $sessionWasCreated->meeting();
        $this->status = $sessionWasCreated->status();
        $this->vilmaClassId = $sessionWasCreated->vilmaClassId();
        $this->creationDate = $sessionWasCreated->creationDate();
        $this->updatedAt = $sessionWasCreated->updatedAt();
        $this->maxParticipants = $sessionWasCreated->maxParticipants();
        $this->numBookings = $sessionWasCreated->numBookings();
    }

    #[Pure] public function getAggregateRootId(): string
    {
        return $this->id->toString();
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
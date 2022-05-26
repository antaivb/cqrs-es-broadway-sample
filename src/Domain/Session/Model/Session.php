<?php

namespace App\Domain\Session\Model;

use App\Domain\Session\Event\SessionWasCreated;
use App\Domain\Session\Model\ValueObject\Duration;
use App\Domain\Session\Model\ValueObject\MaxParticipants;
use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Session\Model\ValueObject\NumBookings;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Model\ValueObject\Status\Status;
use App\Domain\Session\Specification\UniqueSessionSpecificationInterface;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\UpdatedAt;
use App\Domain\Shared\ValueObject\When;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use JetBrains\PhpStorm\Pure;

class Session extends EventSourcedAggregateRoot
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

    public static function create(
        SessionId $id,
        When $when,
        Duration $duration,
        ?Meeting $meeting,
        Status $status,
        UpdatedAt $updatedAt,
        MaxParticipants $maxParticipants,
        NumBookings $numBookings,
        UniqueSessionSpecificationInterface $uniqueSessionSpecification,
    ): self {
        $uniqueSessionSpecification->isUnique($id);

        $session = new self();
        $session->apply(SessionWasCreated::withData(
            $id,
            $when,
            $duration,
            $meeting,
            $status,
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

    public function when(): When
    {
        return $this->when;
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

    public function updatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function maxParticipants(): MaxParticipants
    {
        return $this->maxParticipants;
    }

    public function numBookings(): NumBookings
    {
        return $this->numBookings;
    }
}
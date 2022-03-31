<?php

declare(strict_types=1);

namespace App\Application\Command\Session\Create;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\VilmaClass\Model\ValueObject\VilmaClassId;
use Assert\Assertion;
use JetBrains\PhpStorm\Pure;

final class CreateSessionCommand implements CommandInterface
{
    private int $duration;
    private Meeting $meeting;
    private VilmaClassId $vilmaClassId;
    private int $maxParticipants;
    private \DateTimeInterface $when;

    protected function __constructor(){}

    #[Pure] public static function withData(
        int $duration,
        string $meetingUrl,
        string $meetingHostUrl,
        string $vilmaClassId,
        int $maxParticipants,
        string $when
    ): self {
        Assertion::integer($duration);
        Assertion::integer($maxParticipants);
        Assertion::date($when, 'Y-m-d H:i:s');

        $command = new self();

        $command->duration = $duration;
        $command->maxParticipants = $maxParticipants;
        $command->meeting = Meeting::fromString($meetingUrl, $meetingHostUrl);
        $command->vilmaClassId = VilmaClassId::fromString($vilmaClassId);
        $command->when = new \DateTime($when);

        return $command;
    }

    public function duration(): int
    {
        return $this->duration;
    }

    public function meeting(): Meeting
    {
        return $this->meeting;
    }

    public function vilmaClassId(): VilmaClassId
    {
        return $this->vilmaClassId;
    }

    public function maxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function when(): \DateTimeInterface
    {
        return $this->when;
    }
}

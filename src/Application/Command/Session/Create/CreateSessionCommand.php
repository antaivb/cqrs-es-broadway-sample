<?php

declare(strict_types=1);

namespace App\Application\Command\Session\Create;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\Session\Model\ValueObject\Duration;
use App\Domain\Session\Model\ValueObject\MaxParticipants;
use App\Domain\Session\Model\ValueObject\Meeting;
use App\Domain\Shared\ValueObject\When;
use Assert\Assertion;

final class CreateSessionCommand implements CommandInterface
{
    private Duration $duration;
    private Meeting $meeting;
    private MaxParticipants $maxParticipants;
    private When $when;

    protected function __constructor(){}

    public static function withData(
        int $duration,
        string $meetingUrl,
        string $meetingHostUrl,
        int $maxParticipants,
        string $when
    ): self {
        Assertion::integer($duration);
        Assertion::integer($maxParticipants);
        Assertion::date($when, 'Y-m-d H:i:s');
        Assertion::string($meetingUrl);
        Assertion::string($meetingHostUrl);

        $command = new self();

        $command->duration = Duration::fromInt($duration);
        $command->maxParticipants = MaxParticipants::fromInt($maxParticipants);
        $command->meeting = Meeting::fromString($meetingUrl, $meetingHostUrl);
        $command->when = When::fromString($when);

        return $command;
    }

    public function duration(): Duration
    {
        return $this->duration;
    }

    public function meeting(): Meeting
    {
        return $this->meeting;
    }

    public function maxParticipants(): MaxParticipants
    {
        return $this->maxParticipants;
    }

    public function when(): When
    {
        return $this->when;
    }
}

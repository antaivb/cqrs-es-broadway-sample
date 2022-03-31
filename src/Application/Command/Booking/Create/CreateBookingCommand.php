<?php

declare(strict_types=1);

namespace App\Application\Command\Booking\Create;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\User\Model\ValueObject\UserId;

final class CreateBookingCommand implements CommandInterface
{
    private UserId $userId;
    private SessionId $sessionId;
    private bool $sendConfirmation;

    protected function __constructor(){}

    public static function withData(
        string $userId,
        string $sessionId,
        bool $sendConfirmation = true
    ): self {
        $command = new self();

        $command->userId = UserId::fromString($userId);
        $command->sessionId = SessionId::fromString($sessionId);
        $command->sendConfirmation = $sendConfirmation;

        return $command;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function sessionId(): SessionId
    {
        return $this->sessionId;
    }

    public function sendConfirmation(): bool
    {
        return $this->sendConfirmation;
    }
}

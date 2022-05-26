<?php

declare(strict_types=1);

namespace App\Application\Command\User\UpdateName;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Model\ValueObject\UserId;

final class UpdateNameCommand implements CommandInterface
{
    private UserId $id;
    private Name $name;

    protected function __construct() {}

    public static function withData(
        string $id,
        string $name,
    ): self {
        $command = new self();

        $command->id = UserId::fromString($id);
        $command->name = Name::fromString($name);

        return $command;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }
}

<?php

namespace App\Domain\User\Event;

use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Model\ValueObject\UserId;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\ArrayShape;

final class NameWasUpdated implements Serializable
{
    private UserId $id;
    private Name $name;

    protected function __construct() {}

    public static function withData(
        UserId $id,
        Name $name
    ): self {
        $event = new self();

        $event->id = $id;
        $event->name = $name;

        return $event;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    #[ArrayShape(['id' => "string", 'name' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            UserId::fromString($data['id']),
            Name::fromString($data['name'])
        );
    }
}
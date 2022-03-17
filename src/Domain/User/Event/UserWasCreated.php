<?php

namespace App\Domain\User\Event;

use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\ArrayShape;

final class UserWasCreated implements Serializable
{
    private UserId $id;
    private Name $name;
    private Credentials $credentials;
    private CreationDate $creationDate;

    public function __construct(
        UserId $id,
        Name $name,
        Credentials $credentials,
        CreationDate $creationDate
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->credentials = $credentials;
        $this->creationDate = $creationDate;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function createdAt(): CreationDate
    {
        return $this->creationDate;
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'email' => "string", 'hashedPassword' => "string", 'creationDate' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'email' => $this->credentials()->email()->toString(),
            'hashedPassword' => $this->credentials()->password()->toString(),
            'creationDate' => $this->createdAt()->toString()
        ];
    }

    public static function deserialize(array $data): self
    {
        return new self(
            UserId::fromString($data['id']),
            Name::fromString($data['name']),
            new Credentials($data['email'], $data['hashedPassword']),
            CreationDate::fromString($data['creationDate'])
        );
    }
}
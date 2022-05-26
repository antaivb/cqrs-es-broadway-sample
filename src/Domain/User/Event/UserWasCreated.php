<?php

namespace App\Domain\User\Event;

use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Lastname;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\ArrayShape;

final class UserWasCreated implements Serializable
{
    private UserId $id;
    private Name $name;
    private Lastname $lastname;
    private Credentials $credentials;
    private CreationDate $creationDate;

    protected function __construct() {}

    public static function withData(
        UserId       $id,
        Name         $name,
        Lastname     $lastname,
        Credentials  $credentials,
        CreationDate $creationDate
    ): self {
        $event = new self();

        $event->id = $id;
        $event->name = $name;
        $event->lastname = $lastname;
        $event->credentials = $credentials;
        $event->creationDate = $creationDate;

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

    public function lastname(): Lastname
    {
        return $this->lastname;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function createdAt(): CreationDate
    {
        return $this->creationDate;
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'lastname' => "string", 'email' => "string", 'hashedPassword' => "string", 'creationDate' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'lastname' => $this->lastname()->toString(),
            'email' => $this->credentials()->email()->toString(),
            'hashedPassword' => $this->credentials()->password()->toString(),
            'creationDate' => $this->createdAt()->toString()
        ];
    }

    public static function deserialize(array $data): self
    {
        return self::withData(
            UserId::fromString($data['id']),
            Name::fromString($data['name']),
            Lastname::fromString($data['lastname']),
            new Credentials(Email::fromString($data['email']), HashedPassword::fromHash($data['hashedPassword'])),
            CreationDate::fromString($data['creationDate'])
        );
    }
}
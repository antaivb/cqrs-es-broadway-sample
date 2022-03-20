<?php

declare(strict_types=1);

namespace App\Infrastructure\User\ReadModel;

use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class UserView implements SerializableReadModel
{
    private UserId $id;
    private Name $name;
    private Email $email;
    private CreationDate $creationDate;
    private HashedPassword $hashedPassword;

    #[Pure] public function __construct(
        UserId $id,
        Name $name,
        Credentials $credentials,
        CreationDate $creationDate,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->creationDate = $creationDate;
        $this->hashedPassword = $credentials->password();
        $this->email = $credentials->email();
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function setHashedPassword(HashedPassword $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    public static function deserialize(array $data): UserView
    {
        return new self(
            UserId::fromString($data['id']),
            Name::fromString($data['name']),
            new Credentials(Email::fromString($data['email']), HashedPassword::fromHash($data['hashedPassword'])),
            CreationDate::fromString($data['creationDate'])
        );
    }

    #[ArrayShape(['id' => "string", 'name' => "string", 'email' => "string", 'hashedPassword' => "string", 'creationDate' => "string"])]
    public function serialize(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'email' => $this->email()->toString(),
            'hashedPassword' => $this->hashedPassword()->toString(),
            'creationDate' => $this->creationDate()->toString()
        ];
    }

    public static function fromSerializable(Serializable $event): self
    {
        return self::deserialize($event->serialize());
    }

    #[Pure] public function getId(): string
    {
        return $this->id()->toString();
    }
}

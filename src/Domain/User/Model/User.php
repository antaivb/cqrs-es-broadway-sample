<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\Shared\ValueObject\Lastname;
use App\Domain\User\Event\NameWasUpdated;
use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Specification\ExistUserSpecificationInterface;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

class User extends EventSourcedAggregateRoot
{
    private UserId $id;
    private Name $name;
    private Lastname $lastname;
    private Email $email;
    private HashedPassword $hashedPassword;
    private CreationDate $creationDate;

    protected function __construct() {}

    public static function create(
        UserId                            $id,
        Name                              $name,
        Lastname                          $lastname,
        Credentials                       $credentials,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): self {
        $uniqueEmailSpecification->isUnique($credentials->email());

        $user = new self();
        $user->apply(UserWasCreated::withData(
            $id,
            $name,
            $lastname,
            $credentials,
            CreationDate::generate(),
        ));

        return $user;
    }

    public static function recreate(
        UserId                          $id,
        Name                            $name,
        Lastname                        $lastname,
        Credentials                     $credentials,
        ExistUserSpecificationInterface $existUserSpecification
    ): self {
        $existUserSpecification->exist($id);

        $user = new self();
        $user->apply(UserWasCreated::withData(
            $id,
            $name,
            $lastname,
            $credentials,
            CreationDate::generate(),
        ));

        return $user;
    }

    public function updateName(Name $name): void
    {
        $this->apply(NameWasUpdated::withData($this->id(), $name));
    }

    protected function applyUserWasCreated(UserWasCreated $userWasCreated): void
    {
        $this->id = $userWasCreated->id();
        $this->name = $userWasCreated->name();
        $this->lastname = $userWasCreated->lastname();
        $this->creationDate = $userWasCreated->createdAt();
        $this->hashedPassword = $userWasCreated->credentials()->password();
        $this->email = $userWasCreated->credentials()->email();
    }

    protected function applyNameWasUpdated(NameWasUpdated $nameWasUpdated): void
    {
        $this->name = $nameWasUpdated->name();
    }

    #[Pure] public function getAggregateRootId(): string
    {
        return $this->id->toString();
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

    public function email(): Email
    {
        return $this->email;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function creationDate(): CreationDate
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
            'email' => $this->email()->toString(),
            'hashedPassword' => $this->hashedPassword()->toString(),
            'creationDate' => $this->creationDate()->toString()
        ];
    }

    public static function deserialize(array $data): User
    {
        $user = new self();

        $user->id = UserId::fromString($data['id']);
        $user->name = Name::fromString($data['name']);
        $user->lastname = Lastname::fromString($data['lastname'] ?? 'D');
        $user->creationDate = CreationDate::fromString($data['creationDate']);
        $user->hashedPassword = HashedPassword::fromHash($data['hashedPassword']);
        $user->email = Email::fromString($data['email']);

        return $user;
    }
}

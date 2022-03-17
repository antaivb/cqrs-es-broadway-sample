<?php

declare(strict_types=1);

namespace App\Domain\User\Model;

use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;

class User
{
    private UserId $id;
    private Name $name;
    private Email $email;
    private HashedPassword $hashedPassword;
    private CreationDate $creationDate;

    public static function create(
        UserId $id,
        Name $name,
        Credentials $credentials,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): self {
        $uniqueEmailSpecification->isUnique($credentials->getEmail());

        $user = new self();

        $user->setId($id);
        $user->setName($name);
        $user->setEmail($credentials->getEmail());
        $user->setHashedPassword($credentials->getPassword());
        $user->setCreationDate(CreationDate::now());

        return $user;
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

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function creationDate(): CreationDate
    {
        return $this->creationDate;
    }

    public function setId(UserId $id): void
    {
        $this->id = $id;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setHashedPassword(HashedPassword $hashedPassword): void
    {
        $this->hashedPassword = $hashedPassword;
    }

    public function setCreationDate(CreationDate $creationDate): void
    {
        $this->creationDate = $creationDate;
    }
}

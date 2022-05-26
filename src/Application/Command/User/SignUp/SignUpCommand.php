<?php

declare(strict_types=1);

namespace App\Application\Command\User\SignUp;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\Shared\ValueObject\Lastname;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;

final class SignUpCommand implements CommandInterface
{
    private Name $name;
    private Lastname $lastname;
    private Credentials $credentials;

    protected function __construct() {}

    public static function withData(
        string $name,
        string $lastname,
        string $email,
        string $plainPassword,
    ): self {
        $command = new self();

        $command->name = Name::fromString($name);
        $command->lastname = Lastname::fromString($lastname);
        $email = Email::fromString($email);
        $hashedPassword = HashedPassword::encode($plainPassword);
        $command->credentials = new Credentials($email, $hashedPassword);

        return $command;
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
}

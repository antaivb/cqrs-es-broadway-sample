<?php

declare(strict_types=1);

namespace App\Application\Command\User\SignUp;

use App\Application\Command\Shared\CommandInterface;
use App\Domain\User\Model\ValueObject\Auth\Credentials;
use App\Domain\User\Model\ValueObject\Auth\HashedPassword;
use App\Domain\Shared\ValueObject\Email;
use App\Domain\Shared\ValueObject\Name;

final class SignUpCommand implements CommandInterface
{
    private Name $name;
    private Credentials $credentials;

    public function __construct(
        string $name,
        string $email,
        string $plainPassword,
    ) {
        $this->name = Name::fromString($name);
        $email = Email::fromString($email);
        $hashedPassword = HashedPassword::encode($plainPassword);
        $this->credentials = new Credentials($email, $hashedPassword);
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\User\Model\ValueObject\Auth;

use App\Domain\Shared\ValueObject\Email;

class Credentials
{
    public Email $email;
    public HashedPassword $password;

    public function __construct(Email $email, HashedPassword $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): HashedPassword
    {
        return $this->password;
    }
}

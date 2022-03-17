<?php

declare(strict_types=1);

namespace App\Domain\User\Specification;

use App\Domain\Shared\ValueObject\Email;

interface UniqueEmailSpecificationInterface
{
    public function isUnique(Email $email): void;
}

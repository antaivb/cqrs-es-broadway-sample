<?php

declare(strict_types=1);

namespace App\Domain\User\Specification;

use App\Domain\User\Model\ValueObject\UserId;

interface ExistUserSpecificationInterface
{
    public function exist(UserId $id): void;
}

<?php

declare(strict_types=1);

namespace App\Domain\Session\Specification;

use App\Domain\Session\Model\ValueObject\SessionId;

interface ExistSessionSpecificationInterface
{
    public function exist(SessionId $id): void;
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\Specification;

abstract class AbstractSpecification
{
    abstract public function isSatisfiedBy($value): void;
}

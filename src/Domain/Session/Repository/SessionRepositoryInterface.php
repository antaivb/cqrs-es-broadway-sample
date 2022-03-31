<?php

namespace App\Domain\Session\Repository;

use App\Domain\Session\Model\ValueObject\SessionId;
use App\Infrastructure\Session\ReadModel\SessionView;

interface SessionRepositoryInterface
{
    public function insert(SessionView $session): void;

    public function find(string $id): ?SessionView;
}
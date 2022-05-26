<?php



namespace App\Domain\Session\Repository;

use App\Domain\Session\Model\Session;
use App\Domain\Session\Model\ValueObject\SessionId;

interface SessionStoreRepositoryInterface
{
    public function store(Session $session): void;

    public function get(SessionId $id): Session;
}

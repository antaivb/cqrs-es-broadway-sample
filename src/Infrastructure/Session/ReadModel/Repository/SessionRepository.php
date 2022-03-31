<?php

declare(strict_types=1);

namespace App\Infrastructure\Session\ReadModel\Repository;

use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Infrastructure\Session\ReadModel\SessionView;
use App\Infrastructure\Shared\Persistence\DoctrineRepository;

class SessionRepository extends DoctrineRepository implements SessionRepositoryInterface
{
    public function insert(SessionView $session): void
    {
        $this->persist($session);
    }

    public function find(string $id): ?SessionView
    {
        $sessionRepository = $this->repository(SessionView::class);

        $qb = $sessionRepository
            ->createQueryBuilder('session')
            ->where('session.id = :id')
            ->setParameter('id', $id);

        return $this->oneOrException($qb);
    }
}

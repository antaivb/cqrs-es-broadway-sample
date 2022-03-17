<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Persistence;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class DoctrineRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist($entity): void
    {
        $this->entityManager()->persist($entity);
        $this->flush();
    }

    protected function persistWithoutFlush($entity): void
    {
        $this->entityManager()->persist($entity);
    }

    protected function flush(): void
    {
        $this->entityManager()->flush();
    }

    protected function remove($entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

    protected function oneOrException(QueryBuilder $queryBuilder, int $hydration = AbstractQuery::HYDRATE_OBJECT)
    {
        $model = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult($hydration)
        ;

        if (null === $model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    protected function getOrException(QueryBuilder $queryBuilder, int $hydration = AbstractQuery::HYDRATE_OBJECT)
    {
        $model = $queryBuilder
            ->getQuery()
            ->setHint(Query::HINT_INCLUDE_META_COLUMNS, true)
            ->getResult($hydration)
        ;

        if (null === $model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}

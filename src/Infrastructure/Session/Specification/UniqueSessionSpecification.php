<?php

declare(strict_types=1);

namespace App\Infrastructure\Session\Specification;

use App\Domain\Session\Exception\SessionAlreadyExistsException;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Domain\Session\Specification\UniqueSessionSpecificationInterface;
use App\Domain\Shared\Specification\AbstractSpecification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class UniqueSessionSpecification extends AbstractSpecification implements UniqueSessionSpecificationInterface
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository
    ) {}

    public function isUnique(SessionId $id): void
    {
        $this->isSatisfiedBy($id->toString());
    }

    public function isSatisfiedBy($value): void
    {
        try {
            $this->sessionRepository->find($value);
            throw new SessionAlreadyExistsException();
        } catch (NotFoundHttpException $e) {}
    }
}

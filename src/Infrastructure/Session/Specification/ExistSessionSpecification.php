<?php

declare(strict_types=1);

namespace App\Infrastructure\Session\Specification;

use App\Domain\Session\Exception\SessionNotFoundException;
use App\Domain\Session\Model\ValueObject\SessionId;
use App\Domain\Session\Repository\SessionRepositoryInterface;
use App\Domain\Session\Specification\ExistSessionSpecificationInterface;
use App\Domain\Shared\Specification\AbstractSpecification;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExistSessionSpecification extends AbstractSpecification implements ExistSessionSpecificationInterface
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository
    ) {}

    public function exist(SessionId $id): void
    {
        $this->isSatisfiedBy($id->toString());
    }

    public function isSatisfiedBy($value): void
    {
        try {
            $this->sessionRepository->find($value);
        } catch (NotFoundHttpException $e) {
            throw new SessionNotFoundException();
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Specification;

use App\Domain\Shared\Specification\AbstractSpecification;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Model\ValueObject\UserId;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Specification\ExistUserSpecificationInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExistUserSpecification extends AbstractSpecification implements ExistUserSpecificationInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function exist(UserId $id): void
    {
        $this->isSatisfiedBy($id->toString());
    }

    public function isSatisfiedBy($value): void
    {
        try {
            $this->userRepository->findById($value);
        } catch (NotFoundHttpException $e) {
            throw new UserNotFoundException();
        }
    }
}

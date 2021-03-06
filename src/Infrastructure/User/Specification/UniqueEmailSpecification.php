<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Specification;

use App\Domain\Shared\Specification\AbstractSpecification;
use App\Domain\User\Exception\EmailAlreadyExistException;
use App\Domain\User\Specification\UniqueEmailSpecificationInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\Shared\ValueObject\Email;
use Doctrine\ORM\NonUniqueResultException;

final class UniqueEmailSpecification extends AbstractSpecification implements UniqueEmailSpecificationInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function isUnique(Email $email): void
    {
        $this->isSatisfiedBy($email->toString());
    }

    public function isSatisfiedBy($value): void
    {
        try {
            if ($this->userRepository->findByEmail($value)) {
                throw new EmailAlreadyExistException();
            }
        } catch (NonUniqueResultException $e) {
            throw new EmailAlreadyExistException();
        }
    }
}

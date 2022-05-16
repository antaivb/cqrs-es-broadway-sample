<?php

declare(strict_types=1);

namespace App\Application\Query\User\Get;

use App\Application\Query\Shared\QueryHandlerInterface;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use App\Domain\User\Specification\ExistUserSpecificationInterface;

final class GetQueryHandler implements QueryHandlerInterface
{
    private UserStoreRepositoryInterface $userStoreRepository;
    private ExistUserSpecificationInterface $existUserSpecification;

    public function __construct(
        UserStoreRepositoryInterface $userStoreRepository,
        ExistUserSpecificationInterface $existUserSpecification
    ) {
        $this->userStoreRepository = $userStoreRepository;
        $this->existUserSpecification = $existUserSpecification;
    }

    public function __invoke(GetQuery $query): User
    {
        $this->existUserSpecification->exist($query->id());
        $user = $this->userStoreRepository->get($query->id());

        return $user;
    }
}

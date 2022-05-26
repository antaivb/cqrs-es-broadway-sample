<?php

declare(strict_types=1);

namespace App\Application\Query\User\Get;

use App\Application\Query\Shared\QueryHandlerInterface;
use App\Domain\User\Repository\UserStoreRepositoryInterface;
use App\Domain\User\Specification\ExistUserSpecificationInterface;
use JetBrains\PhpStorm\ArrayShape;

final class GetQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserStoreRepositoryInterface $userStoreRepository,
        private ExistUserSpecificationInterface $existUserSpecification
    ) {}

    #[ArrayShape(['id' => "string", 'name' => "string", 'email' => "string", 'hashedPassword' => "string", 'creationDate' => "string"])]
    public function __invoke(GetQuery $query): array
    {
        $this->existUserSpecification->exist($query->id());
        $user = $this->userStoreRepository->get($query->id());

        return $user->serialize();
    }
}

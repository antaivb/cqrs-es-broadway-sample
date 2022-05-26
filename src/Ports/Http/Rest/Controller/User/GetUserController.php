<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\User;

use App\Application\Query\User\Get\GetQuery;
use App\Ports\Http\Rest\Controller\QueryController;
use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class GetUserController extends QueryController
{
    /**
     * @Route(
     *     "/user/{id}",
     *     name="get_user",
     *     methods={"GET"}
     * )
     *
     * @OA\Tag(name="User")
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function create(string $id): JsonResponse
    {
        Assertion::uuid($id, 'Not a valid id');

        $user = $this->ask(GetQuery::withData($id));
        return $this->jsonResponse($user);
    }
}

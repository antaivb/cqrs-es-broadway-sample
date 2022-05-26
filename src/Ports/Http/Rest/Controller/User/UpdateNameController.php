<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\User;

use App\Application\Command\User\UpdateName\UpdateNameCommand;
use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use App\Ports\Http\Rest\Controller\CommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class UpdateNameController extends CommandQueryController
{
    /**
     * @Route(
     *     "/update/name/{id}",
     *     name="user_update_name",
     *     methods={"POST"}
     * )
     *
     * @OA\Tag(name="User")
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function updateName(string $id, Request $request): JsonResponse
    {
        $name = $request->get('name');

        Assertion::uuid($id, 'Not valid id');
        Assertion::notNull($name, 'Name can not be null');

        $this->dispatch(UpdateNameCommand::withData($id, $name));
        return $this->jsonResponse(['user' => $id]);
    }
}

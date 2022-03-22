<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\User;

use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use App\Application\Command\User\SignUp\SignUpCommand;
use App\Ports\Http\Rest\Controller\CommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class SignUpController extends CommandQueryController
{
    /**
     * @Route(
     *     "/signup",
     *     name="user_create",
     *     methods={"POST"}
     * )
     *
     * @OA\Tag(name="User")
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');

        Assertion::notNull($name, 'Name can not be null');
        Assertion::notNull($email, 'Email can not be null');
        Assertion::notNull($password, 'Password can not be null');

        $this->handle(SignUpCommand::withData($name, $email, $password));
        return $this->jsonResponse(['user' => $email]);
    }
}

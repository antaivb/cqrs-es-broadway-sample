<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\User;

use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use App\Application\Command\User\SignUp\SignUpCommand;
use App\Domain\User\Exception\InvalidCredentialsException;
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
     * @throws InvalidCredentialsException
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        $name = $request->get('_name');
        $email = $request->get('_email');
        $password = $request->get('_password');
        $city = $request->get('_city');
        $gender = $request->get('_gender');
        $phone = $request->get('_phone');
        $dateBirth = $request->get('_dateBirth');
        $couple = $request->get('_couple');
        $childSurname = $request->get('_childSurname');

        Assertion::notNull($name, 'Name can\'t be null');
        Assertion::notNull($email, 'Email can\'t be null');
        Assertion::notNull($password, 'Password can\'t be null');
        Assertion::notNull($city, 'City can\'t be null');
        Assertion::notNull($gender, 'Gender can\'t be null');
        Assertion::nullOrString($phone, 'Phone can\'t be null');
        Assertion::nullOrString($dateBirth, 'Date Birth can\'t be null');
        Assertion::nullOrString($couple, 'Couple can\'t be null');
        Assertion::nullOrString($childSurname, 'Child Surname can\'t be null');

        $this->handle(new SignUpCommand($name, $email, $password, $gender, $phone, $dateBirth, $couple, $childSurname));

        return $this->jsonResponse(['user' => $email]);
    }
}

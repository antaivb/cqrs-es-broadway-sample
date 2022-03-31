<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\Booking;

use App\Application\Command\Booking\Create\CreateBookingCommand;
use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use App\Application\Command\User\SignUp\SignUpCommand;
use App\Ports\Http\Rest\Controller\CommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class BookingController extends CommandQueryController
{
    /**
     * @Route(
     *     "/booking",
     *     name="booking_create",
     *     methods={"POST"}
     * )
     *
     * @OA\Tag(name="Booking")
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        $sessionId = $request->get('sessionId');
        $userId = $request->get('userId');

        Assertion::uuid($sessionId, 'Invalid id');
        Assertion::uuid($userId, 'Invalid id');

        $this->dispatch(CreateBookingCommand::withData($userId, $sessionId));
        return $this->jsonResponse(['userId' => $userId]);
    }
}

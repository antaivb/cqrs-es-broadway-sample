<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\Session;

use App\Application\Command\Session\Create\CreateSessionCommand;
use Assert\Assertion;
use Assert\AssertionFailedException;
use OpenApi\Annotations as OA;
use App\Ports\Http\Rest\Controller\CommandQueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class SessionController extends CommandQueryController
{
    /**
     * @Route(
     *     "/session",
     *     name="session_create",
     *     methods={"POST"}
     * )
     *
     * @OA\Tag(name="Session")
     * @throws AssertionFailedException
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        $duration = (int) $request->get('duration');
        $meetingUrl = $request->get('meetingUrl');
        $meetingHostUrl = $request->get('meetingHostUrl');
        $vilmaClassId = $request->get('vilmaClassId');
        $maxParticipants = (int) $request->get('maxParticipants');
        $when = $request->get('when');

        Assertion::integer($duration, 'Integer needed');
        Assertion::url($meetingUrl, 'Invalid url');
        Assertion::url($meetingHostUrl, 'Invalid url');
        Assertion::uuid($vilmaClassId, 'Invalid id');
        Assertion::integer($maxParticipants, 'Integer needed');
        Assertion::date($when, 'Y-m-d H:i:s', 'Is not a valid date');

        $this->dispatch(CreateSessionCommand::withData(
            $duration,
            $meetingUrl,
            $meetingHostUrl,
            $vilmaClassId,
            $maxParticipants,
            $when
        ));

        return $this->jsonResponse(['vilmaClassId' => $vilmaClassId]);
    }
}

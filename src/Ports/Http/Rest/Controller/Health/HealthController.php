<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller\Health;

use App\Ports\Http\Rest\Controller\QueryController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

final class HealthController extends QueryController
{
    /**
     * @Route(
     *     "/ping",
     *     name="ping",
     *     methods={"GET"}
     * )
     *
     * @OA\Tag(name="Health")
     * @return JsonResponse
     */
    public function ping(): JsonResponse
    {
        return $this->jsonResponse(['pong']);
    }
}

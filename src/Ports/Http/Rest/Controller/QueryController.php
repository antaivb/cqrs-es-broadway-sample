<?php

declare(strict_types=1);

namespace App\Ports\Http\Rest\Controller;

use App\Application\Query\Shared\QueryBusInterface;
use App\Application\Query\Shared\QueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Throwable;

abstract class QueryController
{
    private QueryBusInterface $queryBus;
    private UrlGeneratorInterface $router;

    public function __construct(QueryBusInterface $queryBus, UrlGeneratorInterface $router)
    {
        $this->queryBus = $queryBus;
        $this->router = $router;
    }

    /**
     * @throws Throwable
     */
    protected function ask(QueryInterface $query)
    {
        return $this->queryBus->ask($query);
    }

    public function jsonResponse(array $data, ?int $httpStatus = JsonResponse::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            json_encode($data),
            $httpStatus,
            ['content-type' => 'application/json; charset=utf-8'],
            true
        );
    }
}

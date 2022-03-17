<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class ForbiddenException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Forbidden exception', JsonResponse::HTTP_BAD_REQUEST);
    }
}

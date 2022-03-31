<?php

namespace App\Domain\Session\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class SessionNotFoundException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Session not exists.', JsonResponse::HTTP_NOT_FOUND);
    }
}

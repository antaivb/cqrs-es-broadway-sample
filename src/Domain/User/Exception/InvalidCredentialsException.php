<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidCredentialsException extends \RuntimeException
{
    public function __construct(?string $error = 'Invalid credentials')
    {
        parent::__construct($error, JsonResponse::HTTP_UNAUTHORIZED);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailAlreadyExistException extends \InvalidArgumentException
{
    #[Pure] public function __construct()
    {
        parent::__construct('Email already registered', JsonResponse::HTTP_BAD_REQUEST);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class UserNotFoundException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('User not exists.', JsonResponse::HTTP_NOT_FOUND);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class InvalidInputDataException extends \Exception
{
    public function __construct(\Exception $e)
    {
        parent::__construct('Invalid input data', JsonResponse::HTTP_BAD_REQUEST, $e);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class DateTimeException extends \Exception
{
    public function __construct(\Exception $e)
    {
        parent::__construct('Datetime malformed or not valid', JsonResponse::HTTP_BAD_REQUEST, $e);
    }
}

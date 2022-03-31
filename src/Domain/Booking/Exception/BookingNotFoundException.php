<?php

namespace App\Domain\Booking\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class BookingNotFoundException  extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Booking not exists.', JsonResponse::HTTP_NOT_FOUND);
    }
}
<?php

namespace App\Domain\Booking\Exception;

use Symfony\Component\HttpFoundation\Response;

class BookingNotFoundException  extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Booking not exists.', Response::HTTP_NOT_FOUND);
    }
}
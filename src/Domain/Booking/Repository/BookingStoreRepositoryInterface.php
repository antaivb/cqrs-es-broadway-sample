<?php

/**
 *  This file is part of the ProntoPiso software platform.
 *
 *  Copyright (c) 2020 ProntoPiso S.L.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @author ProntoPiso Dev Team <admin@prontopiso.com>
 */

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Model\Booking;
use App\Domain\Booking\Model\ValueObject\BookingId;

interface BookingStoreRepositoryInterface
{
    public function store(Booking $booking): void;

    public function get(BookingId $id): Booking;
}

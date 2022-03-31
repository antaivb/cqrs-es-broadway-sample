<?php

namespace App\Domain\Session\Model\ValueObject\Status;

class StatusFactory
{
    public static function makePending(): Status
    {
        return Status::fromInt(Status::ALLOWED_STATUSES['PENDING']);
    }

    public static function makeEnabled(): Status
    {
        return Status::fromInt(Status::ALLOWED_STATUSES['ENABLED']);
    }

    public static function makeDisabled(): Status
    {
        return Status::fromInt(Status::ALLOWED_STATUSES['DISABLED']);
    }
}
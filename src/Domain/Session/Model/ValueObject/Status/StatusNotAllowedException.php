<?php

namespace App\Domain\Session\Model\ValueObject\Status;

use JetBrains\PhpStorm\Pure;

class StatusNotAllowedException extends \Exception
{
    #[Pure] public function __construct()
    {
        parent::__construct($this->buildMessage());
    }

    private function buildMessage(): string
    {
        $message = "The status should be ";
        foreach (Status::ALLOWED_STATUSES
                 as $key => $allowedStatus) {
            if ($key == array_key_first(Status::ALLOWED_STATUSES)) {
                $message .= $allowedStatus . ": " . $key;
            }
            if (
                $key != array_key_first(Status::ALLOWED_STATUSES)
                && $key != array_key_last(Status::ALLOWED_STATUSES)
            ) {
                $message .= ", " . $allowedStatus . ": " . $key;
            }
            if ($key == array_key_last(Status::ALLOWED_STATUSES)) {
                $message .= " or " . $allowedStatus . ": " . $key . ".";
            }
        }

        return $message;
    }
}
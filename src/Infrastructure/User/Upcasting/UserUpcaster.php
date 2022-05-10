<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Upcasting;

class UserUpcaster
{
    public function upcast(array $serializedEvent, int $playhead): array
    {
        $event = $serializedEvent['payload'];
        if (!isset($event['lastname'])) {
            $splitValue = explode(' ', $serializedEvent['payload']['name']);
            if (count($splitValue) > 1) {
                $serializedEvent['payload']['name'] = $splitValue[0];
                $serializedEvent['payload']['lastname'] = $splitValue[1];
            } else {
                $serializedEvent['payload']['lastname'] = '';
            }
        }

        return $serializedEvent;
    }
}

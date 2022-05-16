<?php

namespace App\Domain\Shared\Upcasting;

interface Upcaster
{
    /**
     * @param array $serializedEvent
     * @return boolean
     */
    public function supports(array $serializedEvent);

    public function upcast(array $serializedEvent, int $playhead);
}

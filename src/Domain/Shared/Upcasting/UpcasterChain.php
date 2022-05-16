<?php

namespace App\Domain\Shared\Upcasting;

interface UpcasterChain
{
    /**
     * @param array $serializedEvent
     * @param int $playhead
     * @return array the upcasted objects
     */
    public function upcast(array $serializedEvent, int $playhead);
}

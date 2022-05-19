<?php

namespace App\Domain\Shared\Upcasting;

interface UpcasterChain
{
    public function upcast(array $serializedEvent, int $playhead): array;
}

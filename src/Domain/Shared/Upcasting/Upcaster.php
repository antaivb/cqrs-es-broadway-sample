<?php

namespace App\Domain\Shared\Upcasting;

interface Upcaster
{
    public function supports(array $serializedEvent): bool;

    public function upcast(array $serializedEvent, int $playhead);
}

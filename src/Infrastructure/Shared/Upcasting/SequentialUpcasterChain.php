<?php

namespace App\Infrastructure\Shared\Upcasting;

use App\Domain\Shared\Upcasting\UpcasterChain;

final class SequentialUpcasterChain implements UpcasterChain
{
    public function __construct(
        private array $upcasters
    ) {}

    public function upcast(array $serializedEvent, int $playhead): array
    {
        foreach ($this->upcasters as $upcaster) {
            if ($upcaster->supports($serializedEvent)) {
                $serializedEvent = $upcaster->upcast($serializedEvent, $playhead);
            }
        }

        return $serializedEvent;
    }
}

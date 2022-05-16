<?php

namespace App\Infrastructure\Shared\Upcasting;

use App\Domain\Shared\Upcasting\Upcaster;
use App\Domain\Shared\Upcasting\UpcasterChain;

final class SequentialUpcasterChain implements UpcasterChain
{
    /**
     * @var Upcaster[]
     */
    private $upcasters;

    /**
     * @param Upcaster[] $upcasters
     */
    public function __construct(array $upcasters)
    {
        $this->upcasters = $upcasters;
    }

    /**
     * @param array $serializedEvent
     * @param int $playhead
     *
     * @return array the upcasted objects
     */
    public function upcast(array $serializedEvent, int $playhead)
    {
        foreach ($this->upcasters as $upcaster) {
            if ($upcaster->supports($serializedEvent)) {
                $serializedEvent = $upcaster->upcast($serializedEvent, $playhead);
            }
        }

        return $serializedEvent;
    }
}

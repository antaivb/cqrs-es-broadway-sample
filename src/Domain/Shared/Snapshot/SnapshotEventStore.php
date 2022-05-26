<?php

namespace App\Domain\Shared\Snapshot;

use App\Infrastructure\Shared\Snapshot\Snapshot;
use Broadway\Domain\AggregateRoot;

interface SnapshotEventStore
{
    public function append(AggregateRoot $aggregateRoot): void;

    public function load($id): ?Snapshot;
}

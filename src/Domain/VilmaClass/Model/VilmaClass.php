<?php

namespace App\Domain\VilmaClass\Model;

use App\Domain\Shared\ValueObject\CreationDate;
use App\Domain\VilmaClass\Model\ValueObject\VilmaClassId;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use JetBrains\PhpStorm\Pure;

class VilmaClass extends EventSourcedAggregateRoot
{
    private VilmaClassId $id;
    private CreationDate $createdAt;

    protected function __construct() {}

    public static function create(VilmaClassId $id): self
    {
        $vilmaClass = new self();
        $vilmaClass->id = $id;

        return $vilmaClass;
    }

    #[Pure] public function getAggregateRootId(): string
    {
        return $this->id->toString();
    }

    public function id(): VilmaClassId
    {
        return $this->id;
    }
}
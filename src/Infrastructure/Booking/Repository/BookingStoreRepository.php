<?php

declare(strict_types=1);

namespace App\Infrastructure\Booking\Repository;

use App\Domain\Booking\Exception\BookingNotFoundException;
use App\Domain\Booking\Model\Booking;
use App\Domain\Booking\Model\ValueObject\BookingId;
use App\Domain\Booking\Repository\BookingStoreRepositoryInterface;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\ReflectionAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;

class BookingStoreRepository extends EventSourcingRepository implements BookingStoreRepositoryInterface
{
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Booking::class,
            new ReflectionAggregateFactory(),
            $eventStreamDecorators
        );
    }

    public function store(Booking $booking): void
    {
        $this->save($booking);
    }

    public function get(BookingId $id): Booking
    {
        try {
            /** @var Booking $booking */
            $booking = $this->load($id->toString());
        } catch (AggregateNotFoundException $e) {
            throw new BookingNotFoundException();
        }

        return $booking;
    }
}

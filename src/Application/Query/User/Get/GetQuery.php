<?php

declare(strict_types=1);

namespace App\Application\Query\User\Get;

use App\Application\Query\Shared\QueryInterface;
use App\Domain\User\Model\ValueObject\UserId;

final class GetQuery implements QueryInterface
{
    private UserId $id;

    protected function __construct() {}

    public static function withData(
        string $id
    ): self
    {
        $query = new self();

        $query->id = UserId::fromString($id);

        return $query;
    }

    public function id(): UserId
    {
        return $this->id;
    }
}

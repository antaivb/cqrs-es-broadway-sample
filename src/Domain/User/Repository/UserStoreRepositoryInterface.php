<?php

/**
 *  This file is part of the ProntoPiso software platform.
 *
 *  Copyright (c) 2020 ProntoPiso S.L.
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 *  @author ProntoPiso Dev Team <admin@prontopiso.com>
 */

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Model\ValueObject\UserId;

interface UserStoreRepositoryInterface
{
    public function store(User $user): void;

    public function get(UserId $id): User;
}

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

use App\Infrastructure\User\ReadModel\UserView;

interface UserRepositoryInterface
{
    public function save(UserView $user): void;

    public function findByEmail(string $userEmail): ?UserView;

    public function findById(string $id): ?UserView;
}

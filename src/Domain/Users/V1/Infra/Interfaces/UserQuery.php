<?php

declare(strict_types=1);

namespace Domain\Users\V1\Infra\Interfaces;

use Domain\Users\V1\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserQuery
{
    /**
     * Fetch all users from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?string $docType = null, ?string $userId = null): Collection;

    /**
     * @throws ModelNotFoundException
     * @return User
     */
    public static function findById(int $userId): User;
}

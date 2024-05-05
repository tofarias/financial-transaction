<?php

declare(strict_types=1);

namespace Domain\Users\V1\Infra;

use Domain\Users\V1\Models\User;
use Illuminate\Support\Collection;
use Domain\Shared\Services\BaseServiceModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class UserQuery extends BaseServiceModel
{
    /**
     * Fetch all users from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?string $docType = null): Collection
    {
        return User::query()
            ->when($docType, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            })
            ->get();
    }

    /**
     * @throws ModelNotFoundException
     * @return User
     */
    public static function findById(int $userId): User
    {
        return User::findOrFail($userId);
    }
}

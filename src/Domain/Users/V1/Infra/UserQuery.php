<?php

declare(strict_types=1);

namespace Domain\Users\V1\Infra;

use Domain\Users\V1\Models\User;
use Illuminate\Support\Collection;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Users\V1\Infra\Interfaces\UserQuery as UserQueryInterface;

final class UserQuery extends BaseServiceModel implements UserQueryInterface
{
    public static function fetchAll(?string $docType = null, ?string $userId = null): Collection
    {
        return User::query()
            ->when($docType, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            })
            ->when($userId, function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->get();
    }

    public static function findById(int $userId): User
    {
        return User::findOrFail($userId);
    }
}

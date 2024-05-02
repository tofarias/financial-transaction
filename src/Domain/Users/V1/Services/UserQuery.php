<?php

declare(strict_types=1);

namespace Domain\Users\V1\Services;

use Domain\Shared\Services\BaseServiceModel;
use Domain\Users\V1\Enums\EnumDocType;
use Domain\Users\V1\Models\User;
use Illuminate\Support\Collection;

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
            ->when($docType === EnumDocType::CPF->value, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            })
            ->when($docType === EnumDocType::CNPJ->value, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            })
            ->get();
    }
}

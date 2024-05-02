<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Services;

use Domain\Shared\Services\BaseServiceModel;
use Domain\Users\V1\Models\User;
use Domain\Wallets\V1\Models\Wallet;
use Illuminate\Support\Collection;

abstract class WalletQuery extends BaseServiceModel
{
    /**
     * Fetch all wallets from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?string $docType = null): Collection
    {
        return Wallet::query()->with(['user' => function ($query) use ($docType) {
            $query->when($docType, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            });
        }])
            ->get()
            ->filter(fn (Wallet $wallet, int $key) => $wallet->user instanceof User);
    }
}

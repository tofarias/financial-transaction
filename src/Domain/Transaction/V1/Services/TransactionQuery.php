<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Domain\Users\V1\Models\User;
use Illuminate\Support\Collection;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Transaction\V1\Models\Transaction;

abstract class TransactionQuery extends BaseServiceModel
{
    /**
     * Fetch all transactions from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?string $docType = null): Collection
    {
        return Transaction::query()->with(['payer', 'payee' => function ($query) use ($docType) {
            $query->when($docType, function ($query) use ($docType) {
                $query->where('doc_type', $docType);
            });
        }])
            ->get()
            ->filter(fn (Transaction $wallet, int $key) => $wallet->payee instanceof User);
    }
}

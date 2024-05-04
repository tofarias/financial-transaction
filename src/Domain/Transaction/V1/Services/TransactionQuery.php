<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

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
    public static function fetchAll(?int $userId = null): Collection
    {
        return Transaction::query()->with([
            'payerWallet.user',
            'payeeWallet.user',
        ])
            ->get()
            ->filter(function (Transaction $transaction, int $key) use ($userId) {
                if($userId) {
                    if($transaction->payerWallet->user->id == $userId) {
                        return true;
                    }

                    return (bool) ($transaction->payeeWallet->user->id == $userId);
                }

                return true;
            });
    }

    /**
     * @throws ModelNotFoundException
     * @return Transaction
     */
    public static function findById(int $userId): Transaction
    {
        return Transaction::findOrFail($userId);
    }
}

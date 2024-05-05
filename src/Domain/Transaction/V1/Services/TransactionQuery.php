<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Illuminate\Support\Collection;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Transaction\V1\Enums\CacheFetchAllEnum;
use Domain\Transaction\V1\Models\Transaction;
use Illuminate\Support\Facades\Cache;

abstract class TransactionQuery extends BaseServiceModel
{
    /**
     * Fetch all transactions from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?int $userId = null): Collection
    {
        return Cache::rememberForever(CacheFetchAllEnum::FETCH_ALL->value.$userId, function () use ($userId) {
            return Transaction::query()
                ->select('transactions.*')
                ->when($userId, function ($query) use ($userId) {
                    $query->join('wallets as payer_wallets', 'transactions.payer_wallet_id', '=', 'payer_wallets.id')
                        ->join('users as payers_users', 'payer_wallets.user_id', '=', 'payers_users.id')
                        ->join('wallets as payee_wallets', 'transactions.payee_wallet_id', '=', 'payee_wallets.id')
                        ->join('users as payees_users', 'payee_wallets.user_id', '=', 'payees_users.id')
                        ->orWhere(function ($query) use ($userId) {
                            $query->where('payers_users.id', $userId)
                                ->orWhere('payees_users.id', $userId);
                        });
                })
                ->orderBy('transactions.id', 'desc')
                ->get();
        });
    }

    /**
     * @throws ModelNotFoundException
     * @return Transaction
     */
    public static function findById(int $transactionId): Transaction
    {
        return Transaction::findOrFail($transactionId);
    }
}

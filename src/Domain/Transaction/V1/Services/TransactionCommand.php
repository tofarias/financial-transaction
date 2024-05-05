<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Services;

use Illuminate\Support\Collection;
use Domain\Wallets\V1\Models\Wallet;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Transaction\V1\Models\Transaction;
use Domain\Transaction\V1\Exceptions\TransactionException;

abstract class TransactionCommand extends BaseServiceModel
{
    /**
     * Create a transaction.
     *
     * @return Collection
     */
    public static function create(Wallet $payerWallet, Wallet $payeeWallet, $value): Transaction
    {
        if($payerWallet->balance < $value) {
            throw TransactionException::ValueIsGreaterThanWalletBalance();
        }

        if($payerWallet->id == $payeeWallet->id) {
            throw TransactionException::PayerCannotTransferToHimself();
        }

        return Transaction::create([
            'value' => $value,
            'payer_wallet_id' => $payerWallet->id,
            'payee_wallet_id' => $payeeWallet->id,
        ]);
    }

    /** Update 'is_authorized' field. */
    public static function updateStatus(int $transactionId, bool $isAuthorized): void
    {
        $transaction = TransactionQuery::findById($transactionId);
        $transaction->updateOrFail(['is_authorized' => $isAuthorized]);
    }
}

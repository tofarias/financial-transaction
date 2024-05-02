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
     * Fetch all transactions from the database.
     *
     * @return Collection
     */
    public static function create(Wallet $payerWallet, Wallet $payeeWallet, $value): Transaction
    {
        if($payerWallet->balance <= 0) {
            throw new TransactionException('Payer does not have enough balance');
        }

        if($payerWallet->balance < $value) {
            throw new TransactionException('The value is greater than wallet balance');
        }

        if($payerWallet->id == $payeeWallet->id) {
            throw new TransactionException('Payer and payee cannot be in the same wallet');
        }

        return Transaction::create([
            'value' => $value,
            'payer_wallet_id' => $payerWallet->id,
            'payee_wallet_id' => $payeeWallet->id,
        ]);
    }
}

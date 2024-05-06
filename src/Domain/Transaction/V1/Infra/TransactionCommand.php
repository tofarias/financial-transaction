<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Infra;

use Domain\Wallets\V1\Models\Wallet;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Transaction\V1\Models\Transaction;
use Domain\Transaction\V1\Exceptions\TransactionException;
use Domain\Transaction\V1\Infra\Interfaces\TransactionCommand as TransactionCommandInterface;
use Domain\Transaction\V1\Infra\Interfaces\TransactionQuery;

final class TransactionCommand extends BaseServiceModel implements TransactionCommandInterface
{
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

    public static function updateStatus(int $transactionId, bool $isAuthorized): void
    {
        $transaction = app(TransactionQuery::class)->findById($transactionId);
        $transaction->updateOrFail(['is_authorized' => $isAuthorized]);
    }
}

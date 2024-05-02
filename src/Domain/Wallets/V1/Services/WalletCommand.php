<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Services;

use Domain\Shared\Services\BaseServiceModel;
use Domain\Transaction\V1\Exceptions\WalletException;
use Domain\Wallets\V1\Models\Wallet;

abstract class WalletCommand extends BaseServiceModel
{
    /**
     * @param Wallet $payerWallet The payer's wallet.
     * @param float $value
     * @throws WalletException
     * @return void
     */
    public static function debit(Wallet $payerWallet, $value): void
    {
        if( ! $payerWallet->user->isCommon()) {
            throw new WalletException('Payer is not a COMMOM user');
        }

        $payerWallet->balance -= $value;
        $payerWallet->save();
    }
}
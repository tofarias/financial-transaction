<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Infra;

use Domain\Wallets\V1\Models\Wallet;
use Domain\Shared\Services\BaseServiceModel;
use Domain\Wallets\V1\Exceptions\WalletException;
use Domain\Wallets\V1\Infra\Interfaces\WalletCommand as WalletCommandInterface;

final class WalletCommand extends BaseServiceModel implements WalletCommandInterface
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

    /**
     * @param Wallet $payeeWallet The payee's wallet.
     * @param float $value
     * @throws WalletException
     * @return void
     */
    public static function credit(Wallet $payeeWallet, $value): void
    {
        $payeeWallet->balance += $value;
        $payeeWallet->save();
    }
}

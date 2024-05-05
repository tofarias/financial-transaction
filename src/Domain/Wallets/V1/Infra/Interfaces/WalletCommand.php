<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Infra\Interfaces;

use Domain\Wallets\V1\Models\Wallet;
use Domain\Wallets\V1\Exceptions\WalletException;

interface WalletCommand
{
    /**
     * @param Wallet $payerWallet The payer's wallet.
     * @param float $value
     * @throws WalletException
     * @return void
     */
    public static function debit(Wallet $payerWallet, $value): void;

    /**
     * @param Wallet $payeeWallet The payee's wallet.
     * @param float $value
     * @throws WalletException
     * @return void
     */
    public static function credit(Wallet $payeeWallet, $value): void;
}

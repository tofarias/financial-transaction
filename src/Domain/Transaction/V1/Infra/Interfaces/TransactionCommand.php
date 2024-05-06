<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Infra\Interfaces;

use Domain\Wallets\V1\Models\Wallet;
use Domain\Transaction\V1\Models\Transaction;

interface TransactionCommand
{
    /**
     * Create a transaction.
     *
     * @return Collection
     */
    public static function create(Wallet $payerWallet, Wallet $payeeWallet, $value): Transaction;

    /** Update 'is_authorized' field. */
    public static function updateStatus(int $transactionId, bool $isAuthorized): void;
}

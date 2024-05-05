<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Infra\Interfaces;

use Illuminate\Support\Collection;
use Domain\Transaction\V1\Models\Transaction;

interface TransactionQuery
{
    public static function fetchAll(?int $userId = null): Collection;

    /**
     * @throws ModelNotFoundException
     * @return Transaction
     */
    public static function findById(int $transactionId): Transaction;
}

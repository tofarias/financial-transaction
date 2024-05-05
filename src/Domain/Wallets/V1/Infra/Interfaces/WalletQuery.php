<?php

declare(strict_types=1);
namespace Domain\Wallets\V1\Infra\Interfaces;

use Illuminate\Support\Collection;

interface WalletQuery
{
    /**
     * Fetch all wallets from the database.
     *
     * @return Collection
     */
    public static function fetchAll(?string $docType = null): Collection;
}

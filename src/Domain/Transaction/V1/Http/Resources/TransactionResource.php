<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Resources;

use Illuminate\Http\Request;
use Domain\Transactions\V1\Models\Transaction;
use Illuminate\Http\Resources\Json\JsonResource;
use Domain\Wallets\V1\Http\Resources\WalletResource;

/**
 * @property Transaction $resource
 */
class TransactionResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'value' => $this->resource->value,
            'payer_wallet' => new WalletResource($this->resource->payerWallet),
            'payee_wallet' => new WalletResource($this->resource->payeeWallet),
        ];
    }
}

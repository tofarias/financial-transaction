<?php

declare(strict_types=1);

namespace Domain\Transaction\V1\Http\Resources;

use Illuminate\Http\Request;
use Domain\Transactions\V1\Models\Transaction;
use Domain\Users\V1\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'payer' => new UserResource($this->resource->payer),
            'payee' => new UserResource($this->resource->payee),
        ];
    }
}

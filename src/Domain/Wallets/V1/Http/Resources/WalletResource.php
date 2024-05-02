<?php

declare(strict_types=1);

namespace Domain\Wallets\V1\Http\Resources;

use Illuminate\Http\Request;
use Domain\Wallets\V1\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;
use Domain\Users\V1\Http\Resources\User\UserResource;

/**
 * @property Wallet $resource
 */
class WalletResource extends JsonResource
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
            'balance' => $this->resource->balance,
            'user' => new UserResource($this->resource->user),
        ];
    }
}

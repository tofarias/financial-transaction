<?php

declare(strict_types=1);

namespace Domain\Users\V1\Http\Resources;

use Illuminate\Http\Request;
use Domain\Users\V1\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
class UserResource extends JsonResource
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
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'doc_type' => $this->resource->doc_type,
            'doc_number' => $this->resource->doc_number,
            'timezone' => $this->resource->timezone,
        ];
    }
}

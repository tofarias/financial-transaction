<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Api\Authorization;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Domain\Integrations\V1\Api\Authorization\Endpoints\GetAuthorization;
use Illuminate\Support\Traits\Conditionable;

class AuthorizationService
{
    use GetAuthorization;
    use Conditionable;

    protected PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->baseUrl(config('authorization.base_url'));
    }
}

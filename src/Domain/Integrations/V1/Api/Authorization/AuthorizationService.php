<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Api\Authorization;

use Domain\Integrations\V1\Api\Authorization\Endpoints\RequestAuthorization;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Traits\Conditionable;

class AuthorizationService
{
    use RequestAuthorization;
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

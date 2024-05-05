<?php

declare(strict_types=1);

namespace Domain\Integrations\Authorization;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Traits\Conditionable;
use Domain\Integrations\Authorization\Endpoints\RequestAuthorization;

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

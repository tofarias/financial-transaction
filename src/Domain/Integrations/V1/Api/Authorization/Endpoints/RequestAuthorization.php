<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Api\Authorization\Endpoints;

use Illuminate\Http\Client\RequestException;
use Domain\Integrations\V1\Api\Authorization\Enums\AuthorizationEnum;

trait RequestAuthorization
{
    public function isAuthorized(): bool
    {
        try {
            $response = $this->api
                ->get(config('authorization.endpoints.get_authorization'))
                ->throw();

            return $response->json('message') !== AuthorizationEnum::MESSAGE_AUTHORIZED->value;

        } catch (RequestException $th) {
            throw new RequestException($th->response);
        }
    }
}

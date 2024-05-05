<?php

declare(strict_types=1);

namespace Domain\Integrations\Authorization\Endpoints;

use Illuminate\Http\Client\RequestException;
use Domain\Integrations\Authorization\Enums\AuthorizationEnum;

trait RequestAuthorization
{
    public function isAuthorized(): bool
    {
        try {
            $response = $this->api
                ->post(config('authorization.endpoints.get_authorization'))
                ->throw();

            return $response->json('message') === AuthorizationEnum::MESSAGE_AUTHORIZED->value;

        } catch (RequestException $th) {
            throw new RequestException($th->response);
        }
    }
}

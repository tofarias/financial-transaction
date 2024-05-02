<?php

declare(strict_types=1);

namespace Domain\Integrations\V1\Api\Authorization\Endpoints;

use Illuminate\Http\Client\RequestException;
use Domain\Integrations\V1\Api\Authorization\Enums\AuthorizationEnum;
use Domain\Integrations\V1\Api\Authorization\Exceptions\UnauthorizedTransactionException;

trait GetAuthorization
{
    public function getAuthorization(): void
    {

        try {
            $response = $this->api
                ->get(config('authorization.endpoints.get_authorization'))
                ->throw();

            $this->unless($response->json('message') === AuthorizationEnum::MESSAGE_AUTHORIZED->value, function () {
                throw new UnauthorizedTransactionException('Unauthorized Transaction');
            });

            // dd($response->json('message'), $response->json('messageXPTO'));
        } catch (RequestException $th) {
            throw new RequestException($th->response);
        }

    }
}
